<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationLabel = 'Comments';

    protected static ?string $modelLabel = 'Comment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Comment Content
                Forms\Components\Section::make('Comment Content') // Section Title
                    ->description('Enter the content for the comment.')
                    ->schema([
                        Forms\Components\TextInput::make('content')
                            ->required()
                            ->label('Content')
                            ->maxLength(255)
                            ->helperText('The content of the comment. Keep it under 255 characters.'),
                    ]),

                // Section for Reader and Post Selection
                Forms\Components\Section::make('Related Information') // Section Title
                    ->description('Select the reader and post associated with this comment.')
                    ->schema([
                        // Reader Selection
                        Forms\Components\Select::make('reader_id')
                            ->relationship('reader', 'name')
                            ->required()
                            ->label('Reader Name'),
                        // Post Selection
                        Forms\Components\Select::make('post_id')
                            ->relationship('post', 'title')
                            ->required()
                            ->label('Post'),
                        Forms\Components\TextInput::make('content')
                            ->required()
                            ->label('Content'),
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
                Tables\Columns\TextColumn::make('reader.name')
                    ->label('Reader Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->label('Post')
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
