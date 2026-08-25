<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('excerpt')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                Forms\Components\Textarea::make('gallery')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('passengers')
                    ->required()
                    ->numeric()
                    ->default(4),
                Forms\Components\TextInput::make('luggage')
                    ->required()
                    ->numeric()
                    ->default(2),
                Forms\Components\TextInput::make('base_fare')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('per_km')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('per_hour')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('min_fare')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\Textarea::make('features')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\TextInput::make('wp_id')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('excerpt')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('passengers')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('luggage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_fare')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('per_km')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('per_hour')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_fare')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('wp_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
