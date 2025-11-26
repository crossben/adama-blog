<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Planification';
    protected static ?string $navigationLabel = 'Events';

    protected static ?string $modelLabel = 'Event';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Event Details
                Forms\Components\Section::make('Event Details') // Section Title
                    ->description('Enter the details for the event.')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Title')
                            ->maxLength(255)
                            ->reactive()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                // Update the slug if it matches the old one
                                if (($get('slug') ?? '') !== Str::slug($old)) {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            })
                            ->helperText('The title of the item. Keep it under 255 characters.'),

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

                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->label('Description')
                            ->maxLength(500)
                            ->helperText('The description of the event. Keep it under 500 characters.'),

                        Forms\Components\DateTimePicker::make('start_date')
                            ->required()
                            ->label('Start Date'),

                        Forms\Components\DateTimePicker::make('end_date')
                            ->required()
                            ->label('End Date'),

                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->label('Location')
                            ->maxLength(255)
                            ->helperText('The location of the event. Keep it under 255 characters.'),
                    ]),

                // Section for User Selection
                Forms\Components\Section::make('User Selection') // Section Title
                    ->description('Select the user associated with this event.')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->preload()
                            ->default(fn() => auth()->id()) // Set default to the current connected user
                            ->required()
                            ->searchable()
                            ->helperText('Select the user associated with this event.')
                            ->label('User'),
                    ]),
                Forms\Components\Section::make('Category Selection') // Section Title
                    ->description('Select the category associated with this event.')
                    ->schema([
                        Forms\Components\Select::make('categorie_id')
                            ->relationship('categorie', 'title')
                            ->preload()
                            ->required()
                            ->searchable()
                            ->helperText('Select the category associated with this event.')
                            ->label('Category'),
                    ]),

                // Section for Image Upload
                Forms\Components\Section::make('Image Upload') // Section Title
                    ->description('Upload an image for the event.')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Event Image')
                            ->image()
                            ->required()
                            ->maxSize(1024)
                            ->helperText('Upload an image for the event.'),
                    ]),

                // Section for Event URL
                Forms\Components\Section::make('Event URL') // Section Title
                    ->description('Enter the URL for the event.')
                    ->schema([
                        Forms\Components\TextInput::make('url')
                            ->label('Event URL')
                            ->url()
                            ->maxLength(255)
                            ->helperText('The URL for the event. Keep it under 255 characters.'),
                    ]),
                Forms\Components\Section::make('Event Status') // Section Title
                    ->description('Select the status of the event.')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'publier' => 'Publier',
                                'revision' => 'Revision',
                            ])
                            ->required()
                            ->label('Status'),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->html()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
            ])->filters([
                    //
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
