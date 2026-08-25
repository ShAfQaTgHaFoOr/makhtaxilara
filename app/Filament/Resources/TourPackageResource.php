<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourPackageResource\Pages;
use App\Models\TourPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TourPackageResource extends Resource
{
    protected static ?string $model = TourPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Fleet & Packages';

    protected static ?string $navigationLabel = 'Packages';

    protected static ?string $modelLabel = 'Package';

    protected static ?string $pluralModelLabel = 'Packages';

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()?->canAccessResource('packages') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Package')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Package title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Package 1 / Super Package 2'),
                        Forms\Components\TextInput::make('badge')
                            ->label('Vehicle / tag badge')
                            ->maxLength(255)
                            ->placeholder('Hyundai Staria'),
                        Forms\Components\TextInput::make('capacity')
                            ->maxLength(255)
                            ->placeholder('8 Seater 8 Luggage'),
                        Forms\Components\TextInput::make('price')
                            ->label('Price (SAR)')
                            ->required()
                            ->placeholder('1200')
                            ->helperText('Shown as "Total Cost SAR ..."'),
                        Forms\Components\Textarea::make('trips')
                            ->label('Trips (one per line)')
                            ->rows(6)
                            ->columnSpanFull()
                            ->placeholder("Jeddah Airport to Makkah\nMakkah Hotel to Medina Hotel\nMedina Hotel to Medina Airport"),
                    ]),

                Forms\Components\Section::make('Display')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('packages')
                            ->helperText('Car image shown at the bottom of the card.'),
                        Forms\Components\TextInput::make('footer_note')
                            ->maxLength(255)
                            ->default('Full-car options for every trip'),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Display order')
                            ->numeric()->default(0)
                            ->helperText('Lower numbers show first.'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Show on website')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label(''),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('badge')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('capacity')->toggleable()->wrap(),
                Tables\Columns\TextColumn::make('price')->prefix('SAR ')->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->label('Order')->numeric()->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')->label('Live'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Visibility'),
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
            'index' => Pages\ListTourPackages::route('/'),
            'create' => Pages\CreateTourPackage::route('/create'),
            'edit' => Pages\EditTourPackage::route('/{record}/edit'),
        ];
    }
}
