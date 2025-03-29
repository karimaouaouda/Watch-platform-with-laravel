<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeriesResource\Pages;
use App\Models\Series;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeriesResource extends Resource
{
    protected static ?string $model = Series::class;

    protected static ?string $navigationIcon = 'heroicon-o-tv';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->columnSpan(2)
                    ->label('Title')
                    ->required()
                    ->maxLength(255)
                    ->minLength(10)
                    ->hint('The title of the series.')
                    ->prefixIcon('heroicon-o-pencil')
                    ->placeholder('Enter the title of the series.')
                    ->prefixIconColor(Color::Blue),
                Textarea::make('description')
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(1000)
                    ->minLength(10),
                DatePicker::make('release_date')
                    ->columnSpan(2)
                    ->default(now())
                    ->required()
                    ->minDate(now()->subYears(100))
                    ->maxDate(now()->subDays(7))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->prefix('#')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->size('sm'),
                TextColumn::make('description')
                    ->label('Description')
                    ->size('xs')
                    ->words(5)
                    ->tooltip(fn($state) => $state),
                TextColumn::make('release_date')
                    ->badge()
                    ->color(Color::Blue),
                TextColumn::make('created_at')
                    ->badge()
                    ->color(Color::Green),
                TextColumn::make('seasons_count')
                    ->default('0')
                    ->formatStateUsing(function($state){
                        return $state;
                    })->badge(),
                    TextColumn::make('episodes_count')
                    ->default('0')
                    ->formatStateUsing(function($state){
                        return $state;
                    })->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Seasons')
                        ->url(fn($record) => route('filament.admin.resources.series.seasons', $record)),
                    Tables\Actions\DeleteAction::make(),
                ])
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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeries::route('/'),
            'create' => Pages\CreateSeries::route('/create'),
            'edit' => Pages\EditSeries::route('/{record}/edit'),
            'seasons' => Pages\ManageSeriesSeasonsPage::route('/{record}/seasons'),
            'seasons.episodes' => Pages\ManageSeriesEpisodesPage::route('/{record}/seasons/{season}/episodes'),
            'seasons.episodes.create' => Pages\CreateSeriesEpisodePage::route('/{series}/seasons/{season}/episodes/create'),
        ];
    }
}
