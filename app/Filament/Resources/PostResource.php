<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationLabel = 'Posts';

    protected static ?string $modelLabel = 'Post';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Post Details
                Forms\Components\Section::make('Post Details') // Section Title
                    ->description('Enter the details for the post.')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('posts/images')
                            ->imagePreviewHeight('200')
                            ->enableOpen()
                            ->enableDownload()
                            ->nullable(),
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
                            ->helperText('The title of the post. Keep it under 255 characters.'),
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
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->label('Content')
                            ->maxLength(65535)
                            ->helperText('The content of the post.'),
                    ]),

                // Section for User and Category Selection
                Forms\Components\Section::make('Related Information') // Section Title
                    ->description('Select the user and category associated with this post.')
                    ->schema([
                        // User Selection
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->label('Author')
                            ->default(fn() => auth()->id()) // Set default to the current connected user
                            ->helperText('Select the user associated with this post.')
                            ->searchable(),
                        // Category Selection
                        Forms\Components\Select::make('categorie_id')
                            ->relationship('categorie', 'title')
                            ->required()
                            ->label('Category'),

                        // Tag Selection
                    ]),

                // Section for Status
                Forms\Components\Section::make('Post Status') // Section Title
                    ->description('Select the status of the post.')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'revision' => 'Revision',
                                'publier' => 'Publier',
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
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image')
                    ->disk('local')
                    ->label('Image')
                    ->visibility('public')
                    ->square()
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->url(fn($record) => $record->image ? asset('storage/' . $record->image) : null),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Content')
                    ->limit(50)
                    ->html()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('categorie.title')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
