<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Users';

    /** Only super admins can manage users. */
    public static function canAccess(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Account')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true)->maxLength(255),
                        Forms\Components\TextInput::make('phone')->tel()->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation) => $operation === 'create')
                            ->helperText('Leave blank to keep current password (when editing).')
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Role & permissions')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Toggle::make('is_admin')
                            ->label('Can log into admin panel')
                            ->default(true),
                        Forms\Components\Select::make('role')
                            ->options([
                                'super_admin' => 'Super Admin (full access)',
                                'staff'       => 'Staff (limited)',
                            ])
                            ->default('staff')
                            ->required()
                            ->live(),
                        Forms\Components\CheckboxList::make('permissions')
                            ->options(User::PERMISSIONS)
                            ->columns(2)
                            ->columnSpanFull()
                            ->helperText('Choose which sections this user can access.')
                            ->visible(fn (Get $get) => $get('role') !== 'super_admin'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => $state === 'super_admin' ? 'Super Admin' : ucfirst((string) $state))
                    ->color(fn (?string $state) => $state === 'super_admin' ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('created_bookings_count')
                    ->label('Bookings made')
                    ->counts('createdBookings')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_admin')->label('Panel access')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(['super_admin' => 'Super Admin', 'staff' => 'Staff']),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
