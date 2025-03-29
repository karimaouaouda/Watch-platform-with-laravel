<?php

namespace App\Filament\Resources\SeriesResource\Pages;

use App\Filament\Resources\SeriesResource;
use App\Models\Season;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManageSeriesSeasonsPage extends ManageRelatedRecords
{
    protected static string $resource = SeriesResource::class;

    protected static string $relationship = 'seasons';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Seasons';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('season_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('release_date')
                    ->required()
                    ->placeholder('Select a release date')
                    ->minDate(now()->subYears(10))
                    ->maxDate(now()->addYears(10))
                    ->default(now()),
                /* Forms\Components\Select::make('series_id')
                    ->relationship('series', 'title')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->placeholder('Select a series')
                    ->label('Series'), */
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('season_number')
            ->columns([
                Tables\Columns\TextColumn::make('season_number')
                ->badge()
                ->color(Color::Green)
                ->prefix('#'),
                Tables\Columns\TextColumn::make('title')
                    ->words(5)
                    ->tooltip(fn($state) => $state)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->tooltip(fn($state) => $state)
                    ->words(5),
                Tables\Columns\TextColumn::make('release_date')
                    ->date()
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->label('Release Date'),
                Tables\Columns\TextColumn::make('episodes')
                    ->default(1)
                    ->formatStateUsing(fn(Season $record) => $record->episodes()->count())
                    ->badge()

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                //Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Action::make('episodes')
                        ->icon('heroicon-o-square-2-stack')
                        ->url(fn(Season $record) => route('filament.admin.resources.series.seasons.episodes', [
                            'record' => $this->record->id,
                            'season' => $record->id
                        ])),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    //Tables\Actions\DissociateAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DissociateBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
