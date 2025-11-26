<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategorieResource\Pages;
use App\Models\Categorie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class CategorieResource extends Resource
{
    protected static ?string $model = Categorie::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $modelLabel = 'Categorie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Title and Slug Inputs using Grid Layout
                Forms\Components\Section::make('Basic Information') // Section Title
                    ->description('Enter the basic details for the item.')
                    ->schema([
                        // Title Input
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Title')
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                // Update the slug if it matches the old one
                                if (($get('slug') ?? '') !== Str::slug($old)) {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            })
                            ->helperText('The title of the item. Keep it under 255 characters.'),
                        // Slug Input
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            // ->hidden() // Optionally hide the slug field
                            ->label('Reference')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->reactive()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                if ($state === null) {
                                    $set('slug', Str::slug($get('title')));
                                }
                            })
                            // ->hidden()
                            ->readOnly(true)
                            ->required()
                            ->helperText('The URL-friendly version of the title. Automatically generated if not provided.'),
                        Forms\Components\BelongsToSelect::make('user_id')
                            ->relationship('user', 'name') 
                            ->required()
                            // ->hidden()
                            // ->preload()
                            ->label('User')
                            ->default(fn() => auth()->id()) // Set default to the current connected user
                            ->helperText('Select the user associated with this item.'),
                    ]),
                // User Selection
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategorie::route('/create'),
            'edit' => Pages\EditCategorie::route('/{record}/edit'),
        ];
    }
}
