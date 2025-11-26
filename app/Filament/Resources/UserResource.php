<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationLabel = 'Users';

    protected static ?string $modelLabel = 'User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for User Details
                Forms\Components\Section::make('User Details') // Section Title
                    ->description('Enter the basic details for the user.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Name')
                            ->maxLength(255)
                            ->helperText('The name of the user. Keep it under 255 characters.'),

                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->helperText('The email address of the user.'),

                        Forms\Components\TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(15)
                            ->helperText('The phone number of the user.'),
                    ]),

                // Section for Password and Role
                Forms\Components\Section::make('Password and Role') // Section Title
                    ->description('Set the password and assign a role to the user.')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->required()
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->helperText('The password for the user. Must be at least 8 characters long.'),

                        Forms\Components\Select::make('role')
                            ->required()
                            ->label('Role')
                            ->options([
                                'superadmin' => 'Super Admin',
                                'admin' => 'Admin',
                                'editor' => 'Editor',
                                'viewer' => 'Viewer',
                            ])
                            ->helperText('Select the role for the user.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
