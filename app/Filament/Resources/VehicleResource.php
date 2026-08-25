<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Fleet & Packages';

    protected static ?string $navigationLabel = 'Fleet';

    protected static ?string $modelLabel = 'Vehicle';

    protected static ?string $pluralModelLabel = 'Fleet';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()?->canAccessResource('fleet') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Package details')
                    ->description('Name, description and photos shown to customers.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Used in the page URL, e.g. /vehicle/executive-sedan'),
                        Forms\Components\TextInput::make('excerpt')
                            ->label('Short tagline')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->rows(5)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->label('Main image')
                            ->image()
                            ->directory('vehicles')
                            ->imageEditor(),
                        Forms\Components\TagsInput::make('features')
                            ->label('Features')
                            ->placeholder('Add a feature and press Enter')
                            ->helperText('e.g. Air conditioning, Wi-Fi, Child seat')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pricing (package rates)')
                    ->description('Change fares here. Estimated fare = base fare + (per-km × km) or (per-hour × hours), never below the minimum fare.')
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('base_fare')
                            ->required()->numeric()->prefix('$')->default(0),
                        Forms\Components\TextInput::make('per_km')
                            ->label('Per km')
                            ->required()->numeric()->prefix('$')->default(0),
                        Forms\Components\TextInput::make('per_hour')
                            ->label('Per hour')
                            ->required()->numeric()->prefix('$')->default(0),
                        Forms\Components\TextInput::make('min_fare')
                            ->label('Minimum fare')
                            ->required()->numeric()->prefix('$')->default(0),
                    ]),

                Forms\Components\Section::make('Capacity & visibility')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('passengers')
                            ->required()->numeric()->minValue(1)->default(4),
                        Forms\Components\TextInput::make('luggage')
                            ->required()->numeric()->minValue(0)->default(2),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Display order')
                            ->required()->numeric()->default(0)
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('passengers')->numeric()->sortable()->icon('heroicon-m-user-group'),
                Tables\Columns\TextColumn::make('base_fare')->money('USD')->sortable(),
                Tables\Columns\TextColumn::make('per_km')->label('Per km')->money('USD')->sortable(),
                Tables\Columns\TextColumn::make('per_hour')->label('Per hour')->money('USD')->sortable(),
                Tables\Columns\TextColumn::make('min_fare')->label('Min fare')->money('USD')->sortable(),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
