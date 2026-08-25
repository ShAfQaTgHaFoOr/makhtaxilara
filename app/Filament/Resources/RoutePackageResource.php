<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoutePackageResource\Pages;
use App\Models\RoutePackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoutePackageResource extends Resource
{
    protected static ?string $model = RoutePackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'Fleet & Packages';

    protected static ?string $navigationLabel = 'Routes';

    protected static ?string $modelLabel = 'Route';

    protected static ?string $pluralModelLabel = 'Routes';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Route')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Route title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. JEDDAH AIRPORT TO MAKKAH HOTEL')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Display order')
                            ->numeric()->default(0)
                            ->helperText('Lower numbers show first.'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Show on website')
                            ->default(true),
                    ]),

                Forms\Components\Section::make('Package prices')
                    ->description('One row per vehicle type. Shown on the route card. Price is displayed with a "/-" suffix.')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->hiddenLabel()
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('Vehicle')
                                    ->required()
                                    ->placeholder('Camry, Sonata (4 Seater)')
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('price')
                                    ->label('Price')
                                    ->required()
                                    ->placeholder('250'),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->addActionLabel('Add vehicle price')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Route')
                    ->searchable()->sortable()->weight('bold')->wrap(),
                Tables\Columns\TextColumn::make('items')
                    ->label('Prices')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => is_array($state) ? count($state) . ' vehicles' : '0'),
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
            'index' => Pages\ListRoutePackages::route('/'),
            'create' => Pages\CreateRoutePackage::route('/create'),
            'edit' => Pages\EditRoutePackage::route('/{record}/edit'),
        ];
    }
}
