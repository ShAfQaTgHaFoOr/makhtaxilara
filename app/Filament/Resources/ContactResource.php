<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Enquiries';

    protected static ?string $navigationLabel = 'Queries';

    protected static ?string $modelLabel = 'Query';

    protected static ?string $pluralModelLabel = 'Queries';

    protected static ?int $navigationSort = 1;

    /** Show a red badge with the number of unread queries. */
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_read', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->canAccessResource('queries') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Query')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\TextInput::make('email')->email()->required()->maxLength(255),
                        Forms\Components\TextInput::make('phone')->tel()->maxLength(255),
                        Forms\Components\TextInput::make('subject')->maxLength(255),
                        Forms\Components\Textarea::make('message')->required()->rows(6)->columnSpanFull(),
                        Forms\Components\Toggle::make('is_read')->label('Mark as read'),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('created_at')->label('Received')->dateTime(),
                        Infolists\Components\TextEntry::make('email')->copyable()->icon('heroicon-m-envelope'),
                        Infolists\Components\TextEntry::make('phone')->copyable()->icon('heroicon-m-phone')->placeholder('—'),
                        Infolists\Components\TextEntry::make('source')->badge(),
                        Infolists\Components\TextEntry::make('booking.booking_no')
                            ->label('Converted to booking')->badge()->color('success')->placeholder('Not converted'),
                        Infolists\Components\TextEntry::make('subject')->placeholder('—')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('message')->columnSpanFull()->prose(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-s-envelope')
                    ->trueColor('gray')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->sortable()
                    ->weight(fn (Contact $r) => $r->is_read ? null : 'bold'),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('phone')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('subject')->searchable()->limit(40)->placeholder('—'),
                Tables\Columns\TextColumn::make('source')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('booking.booking_no')
                    ->label('Booking')->badge()->color('success')->placeholder('—'),
                Tables\Columns\TextColumn::make('created_at')->label('Received')->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Read status')
                    ->trueLabel('Read')
                    ->falseLabel('Unread'),
                Tables\Filters\TernaryFilter::make('converted')
                    ->label('Converted')
                    ->placeholder('All queries')
                    ->trueLabel('Converted to booking')
                    ->falseLabel('Not yet converted')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('booking_id'),
                        false: fn ($query) => $query->whereNull('booking_id'),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->after(fn (Contact $record) => $record->is_read ?: $record->update(['is_read' => true])),
                static::convertAction(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markRead')
                        ->label('Mark as read')
                        ->icon('heroicon-m-envelope-open')
                        ->action(fn ($records) => $records->each->update(['is_read' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('markUnread')
                        ->label('Mark as unread')
                        ->icon('heroicon-m-envelope')
                        ->action(fn ($records) => $records->each->update(['is_read' => false]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /** Row action: turn a query into a real booking. */
    public static function convertAction(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('convert')
            ->label('Convert to booking')
            ->icon('heroicon-m-arrow-right-circle')
            ->color('success')
            ->visible(fn (Contact $record) => ! $record->isConverted())
            ->modalHeading('Convert query to booking')
            ->modalSubmitActionLabel('Create booking')
            ->fillForm(fn (Contact $record) => [
                'passengers' => 1,
                'notes' => $record->subject
                    ? $record->subject . ' — ' . $record->message
                    : $record->message,
            ])
            ->form(static::convertFormSchema())
            ->action(function (Contact $record, array $data) {
                $booking = static::createBookingFromQuery($record, $data);

                Notification::make()
                    ->success()
                    ->title("Booking {$booking->booking_no} created")
                    ->body("Query from {$record->name} was converted.")
                    ->send();
            });
    }

    /** Shared trip-detail form used by the convert action. */
    public static function convertFormSchema(): array
    {
        return [
            Forms\Components\Select::make('vehicle_id')
                ->label('Vehicle')
                ->options(Vehicle::where('is_active', true)->orderBy('sort_order')->pluck('name', 'id'))
                ->searchable()
                ->required(),
            Forms\Components\TextInput::make('pickup_location')->label('Arrival (flight & time)')->maxLength(200),
            Forms\Components\TextInput::make('dropoff_location')->label('Departure (flight & time)')->maxLength(200),
            Forms\Components\DateTimePicker::make('pickup_at')
                ->label('Booking date & time')
                ->required()->seconds(false)->native(false),
            Forms\Components\TextInput::make('passengers')
                ->numeric()->minValue(1)->default(1)->required(),
            Forms\Components\Textarea::make('notes')->rows(3)->columnSpanFull(),
        ];
    }

    /** Create the booking from a query + the trip form data, and link it back. */
    public static function createBookingFromQuery(Contact $record, array $data): Booking
    {
        $vehicle = Vehicle::findOrFail($data['vehicle_id']);

        $booking = Booking::create([
            'name'             => $record->name,
            'email'            => $record->email,
            'phone'            => $record->phone ?: 'N/A',
            'vehicle_id'       => $vehicle->id,
            'trip_type'        => 'fixed',
            'pickup_location'  => $data['pickup_location'] ?? null,
            'dropoff_location' => $data['dropoff_location'] ?? null,
            'pickup_at'        => $data['pickup_at'],
            'passengers'       => $data['passengers'],
            'notes'            => $data['notes'] ?? null,
            'fare_amount'      => $vehicle->estimateFare('fixed'),
            'status'           => 'confirmed',
            'payment_status'   => 'unpaid',
        ]);

        $record->update(['is_read' => true, 'booking_id' => $booking->id]);

        return $booking;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
