<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\RoutePackage;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Bookings';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()?->canAccessResource('bookings') ?? false;
    }

    /** Staff see only the bookings they created; super admins see all. */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && ! $user->isSuperAdmin()) {
            $query->where('created_by', $user->id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('nationality')
                            ->label('Nationality')
                            ->options(Booking::nationalities())
                            ->searchable()
                            ->placeholder('Select nationality'),
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()->maxLength(255)
                            ->placeholder('Optional'),
                        Forms\Components\TextInput::make('phone')->tel()->required()->maxLength(255),
                    ]),

                Forms\Components\Section::make('Trip')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('pickup_location')
                            ->label('Arrival (flight & time)')
                            ->placeholder('e.g. SV123 arriving 14:30 at Jeddah')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('dropoff_location')
                            ->label('Departure (flight & time)')
                            ->placeholder('e.g. SV456 departing 20:00')
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('pickup_at')
                            ->label('Booking date & time')
                            ->required()->seconds(false)->native(false),
                        Forms\Components\TextInput::make('passengers')->numeric()->minValue(1)->default(1)->required(),
                        Forms\Components\Textarea::make('notes')->rows(3)->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Route legs (optional — for multi-stop invoices)')
                    ->description('Add one row per leg. When any legs are added, the fare is auto-calculated as the sum of (qty × amount) and each leg appears as a line on the invoice.')
                    ->schema([
                        Forms\Components\Repeater::make('route_items')
                            ->hiddenLabel()
                            ->schema([
                                Forms\Components\DatePicker::make('date')->native(false)->displayFormat('Y-m-d')->columnSpan(2),
                                Forms\Components\TimePicker::make('time')->seconds(false)->native(false)->format('H:i')->columnSpan(2),
                                Forms\Components\Select::make('route')
                                    ->options(fn () => RoutePackage::orderBy('name')->pluck('name', 'name'))
                                    ->searchable()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')->label('New route name')->required()->maxLength(255),
                                    ])
                                    ->createOptionUsing(function (array $data): string {
                                        // Added routes are hidden from the website until activated in Routes.
                                        RoutePackage::firstOrCreate(
                                            ['name' => $data['name']],
                                            ['is_active' => false, 'items' => []],
                                        );

                                        return $data['name'];
                                    })
                                    ->columnSpan(3),
                                Forms\Components\Select::make('vehicle')
                                    ->options(fn () => Vehicle::orderBy('name')->pluck('name', 'name'))
                                    ->searchable()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')->label('New vehicle name')->required()->maxLength(255),
                                    ])
                                    ->createOptionUsing(function (array $data): string {
                                        // Added vehicles are hidden from the website fleet until activated in Fleet.
                                        Vehicle::firstOrCreate(
                                            ['name' => $data['name']],
                                            ['slug' => Str::slug($data['name']) . '-' . Str::lower(Str::random(4)), 'is_active' => false],
                                        );

                                        return $data['name'];
                                    })
                                    ->columnSpan(3),
                                Forms\Components\TextInput::make('qty')->numeric()->default(1)->minValue(1)->columnSpan(1),
                                Forms\Components\TextInput::make('amount')->label('Amount')->numeric()->prefix('SAR')->required()->columnSpan(2),
                            ])
                            ->columns(13)
                            ->defaultItems(1)
                            ->addActionLabel('Add route')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['route'] ?? null),
                    ]),

                Forms\Components\Section::make('Payment & status')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('fare_amount')
                            ->numeric()->prefix('$')->required()->default(0)
                            ->helperText('Auto-calculated from route legs when any are added; otherwise set it manually.'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])->default('pending')->required(),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'unpaid' => 'Unpaid',
                                'paid' => 'Paid',
                                'refunded' => 'Refunded',
                            ])->default('unpaid')->required(),
                        Forms\Components\TextInput::make('payment_method')->maxLength(255)->placeholder('cash / stripe'),
                        Forms\Components\TextInput::make('payment_reference')->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('booking_no')->label('Booking')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('name')->label('Customer')->searchable(),
                Tables\Columns\TextColumn::make('vehicle.name')->label('Vehicle')->sortable()->placeholder('—'),
                Tables\Columns\TextColumn::make('pickup_at')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('fare_amount')->money('USD')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state) => $state === 'paid' ? 'success' : ($state === 'refunded' ? 'warning' : 'danger')),
                Tables\Columns\TextColumn::make('createdBy.name')->label('Created by')->toggleable()->placeholder('—'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid' => 'Paid',
                        'refunded' => 'Refunded',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('invoice')
                    ->label('Invoice')
                    ->icon('heroicon-m-document-text')
                    ->color('gray')
                    ->url(fn (Booking $record) => route('booking.invoice', $record->booking_no))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('invoicePdf')
                    ->label('PDF')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('success')
                    ->url(fn (Booking $record) => route('booking.invoice.download', $record->booking_no))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
