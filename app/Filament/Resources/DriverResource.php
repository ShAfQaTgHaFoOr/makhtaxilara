<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Models\Booking;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Drivers';

    public static function canAccess(): bool
    {
        return auth()->user()?->canAccessResource('drivers') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Driver details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\TextInput::make('phone')->tel()->required()->maxLength(255),
                        Forms\Components\TextInput::make('email')->email()->maxLength(255)->placeholder('Optional'),
                        Forms\Components\Select::make('nationality')
                            ->options(Booking::nationalities())
                            ->searchable()
                            ->placeholder('Select nationality'),
                        Forms\Components\TextInput::make('license_no')->label('License no.')->maxLength(255),
                        Forms\Components\TextInput::make('id_number')->label('Iqama / Passport no.')->maxLength(255),
                        Forms\Components\DatePicker::make('joined_at')->label('Joined on')->native(false),
                        Forms\Components\FileUpload::make('photo')->image()->directory('drivers')->imageEditor(),
                    ]),

                Forms\Components\Section::make('Assignment')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('vehicle_id')
                            ->label('Assigned car')
                            ->relationship('vehicle', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('No car assigned yet'),
                        Forms\Components\TextInput::make('vehicle_no')
                            ->label('Vehicle no. (plate)')
                            ->placeholder('e.g. ABC 1234')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')->label('Active')->default(true),
                        Forms\Components\Textarea::make('notes')->rows(3)->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->circular()->label(''),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('phone')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('vehicle.name')->label('Assigned car')->sortable()->placeholder('— none —')->badge()->color('info'),
                Tables\Columns\TextColumn::make('vehicle_no')->label('Vehicle no.')->searchable()->placeholder('—'),
                Tables\Columns\TextColumn::make('nationality')->toggleable()->placeholder('—'),
                Tables\Columns\TextColumn::make('license_no')->label('License')->toggleable()->placeholder('—'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Active'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('vehicle_id')
                    ->label('Assigned car')
                    ->relationship('vehicle', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
