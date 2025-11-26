<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReaderResource\Pages;
use App\Models\Reader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReaderResource extends Resource
{
    protected static ?string $model = Reader::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationLabel = 'Readers';

    protected static ?string $modelLabel = 'Reader';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Reader Details
                Forms\Components\Section::make('Reader Details') // Section Title
                    ->description('Enter the basic details for the reader.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Name')
                            ->maxLength(255)
                            ->helperText('The name of the reader. Keep it under 255 characters.'),

                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->helperText('The email address of the reader.'),

                        Forms\Components\TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(15)
                            ->helperText('The phone number of the reader.'),
                    ]),

                // Section for Password and Role
                Forms\Components\Section::make('Password and Role') // Section Title
                    ->description('Set the password and assign a role to the reader.')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->required()
                            ->label('Password')
                            ->password()
                            ->minLength(8)
                            ->maxLength(255)
                            ->revealable()
                            ->placeholder('Enter password')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(function ($state) {
                                return bcrypt($state);
                            })
                            ->helperText('The password for the reader. Keep it secure.'),
                    ]),

                // Section for Status and Bio
                Forms\Components\Section::make('Status and Bio') // Section Title
                    ->description('Define the status and add a bio for the reader.')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required()
                            ->label('Status')
                            ->helperText('Select the status of the reader.'),

                        Forms\Components\TextInput::make('bio')
                            ->required()
                            ->label('Bio')
                            ->maxLength(500)
                            ->helperText('Enter a brief biography of the reader.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListReaders::route('/'),
            'create' => Pages\CreateReader::route('/create'),
            'edit' => Pages\EditReader::route('/{record}/edit'),
        ];
    }
}
