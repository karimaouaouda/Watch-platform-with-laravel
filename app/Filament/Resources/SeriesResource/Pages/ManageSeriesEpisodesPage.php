<?php

namespace App\Filament\Resources\SeriesResource\Pages;

use App\Filament\Resources\SeriesResource;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageSeriesEpisodesPage extends ManageRecords
{
    protected static string $resource = SeriesResource::class;

    public static function getNavigationLabel(): string
    {
        return 'Episodes';
    }

    protected static ?string $title = 'Episodes';
    public Season $season;
    public Series $record;

    public function mount(): void
    {
        $this->authorizeAccess();

        $this->loadDefaultActiveTab();

        $this->season = request('season');

    }

    protected function getTableQuery(): ?Builder
    {
        return Episode::query()
                            ->where('season_id', $this->season->id);
    }

    protected function configureEditAction(Tables\Actions\EditAction $action): void
    {
        $action->form(function (Form $form) {
            return $this->form($form->columns(2));
        });
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create episode')
                ->color(Color::Blue)
                ->icon('heroicon-s-film')
                ->url(route(
                    CreateSeriesEpisodePage::getRouteName(),
                    ['season' => $this->season->id, 'series' => $this->season->series()->first()->id]
                )),
        ];
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('episode_number')
            ->columns([
                Tables\Columns\TextColumn::make('episode_number')
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
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->label('Release Date'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('watch')
                    ->icon('heroicon-o-eye')
                    ->color(Color::Green)
            ])
            ->emptyStateHeading('No Episodes Found')
            ->emptyStateDescription('Add Episodes To See Them Here')
            ->emptyStateActions([
                Tables\Actions\Action::make('add episode')
                    ->color(Color::Blue)
                    ->icon('heroicon-s-film')
                    ->url(route(
                        CreateSeriesEpisodePage::getRouteName(),
                        ['season' => $this->season->id, 'series' => $this->season->series()->first()->id]
                    )),
            ]);
    }
}
