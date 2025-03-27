<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Models\Movie;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Details')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->placeholder('Enter the movie title'),
                        Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->placeholder('Enter the movie description'),
                        DatePicker::make('release_date')
                            ->label('Release Date')
                            ->required(),
                        TextInput::make('poster_url')
                            ->label('Poster URL')
                            ->required()
                            ->placeholder('Enter the movie poster URL'),
                        TextInput::make('url')
                            ->label('URL')
                            ->required()
                            ->placeholder('Enter the movie URL'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Title'),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label('Description'),
                Tables\Columns\TextColumn::make('release_date')
                    ->searchable()
                    ->label('Release Date'),
                Tables\Columns\TextColumn::make('rating')
                    ->searchable()
                    ->badge()
                    ->color(Color::Yellow)
                    ->label('Rating'),
                Tables\Columns\TextColumn::make('poster_url')
                    ->searchable()
                    ->icon('heroicon-o-link')
                    ->url(fn($state) => $state)
                    ->openUrlInNewTab()
                    ->label('Poster URL'),
                Tables\Columns\TextColumn::make('url')
                    ->searchable()
                    ->icon('heroicon-o-link')
                    ->url(fn($state) => $state)
                    ->openUrlInNewTab()
                    ->label('URL'),
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
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }
}
