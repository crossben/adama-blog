<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebtvResource\Pages;
use App\Models\Webtv;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class WebtvResource extends Resource
{
    protected static ?string $model = Webtv::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Planification';
    protected static ?string $navigationLabel = 'Web TVs';
    protected static ?string $modelLabel = 'Web TV';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Web TV Details
                Forms\Components\Section::make('Web TV Details') // Section Title
                    ->description('Enter the details for the web TV.')
                    ->schema([
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
                            ->helperText('The title of the web TV. Keep it under 255 characters.'),
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
                            ->readOnly(true)
                            ->required()
                            ->helperText('The URL-friendly version of the title. Automatically generated if not provided.'),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->preload()
                            ->default(fn() => auth()->id()) // Set default to the current connected user
                            ->required()
                            ->searchable()
                            ->helperText('Select the user associated with this event.')
                            ->label('User'),

                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->label('Description')
                            ->maxLength(500)
                            ->helperText('The description of the web TV. Keep it under 500 characters.'),
                        Forms\Components\Select::make('categorie_id')
                            ->relationship('categorie', 'title')
                            ->required()
                            ->label('Category'),
                        Forms\Components\Section::make('Event URL')
                            ->description('Enter the URL for the event.')
                            ->schema([
                                Forms\Components\TextInput::make('url')
                                    ->label('Event URL')
                                    ->required()
                                    ->url()
                                    ->suffixIcon('heroicon-m-globe-alt')
                                    ->suffixIconColor('success')
                                    ->maxLength(255)
                                    ->helperText('The URL for the event. Keep it under 255 characters.'),
                            ]),
                        Forms\Components\Section::make('Web Status') // Section Title
                            ->description('Select the status of the web TV.')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'publier' => 'Publier',
                                        'revision' => 'Revision',
                                    ])
                                    ->required()
                                    ->label('Status'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->limit(20)
                    ->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie.title')
                    ->label('Categorie')
                    ->sortable()
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('url')
                    ->label('Event URL')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListWebtvs::route('/'),
            'create' => Pages\CreateWebtv::route('/create'),
            'edit' => Pages\EditWebtv::route('/{record}/edit'),
        ];
    }
}
