<?php

namespace App\Filament\Resources;

use App\Enums\CodeDuration;
use App\Enums\CodeStatus;
use App\Filament\Resources\CodeResource\Pages;
use App\Filament\Resources\CodeResource\RelationManagers;
use App\Models\Code;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CodeResource extends Resource
{
    protected static ?string $model = Code::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $pluralLabel = "License Keys";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->dehydrateStateUsing(fn($state) => Crypt::encrypt($state))
                    ->readOnly()
                    ->default(str_replace('-', '', strtoupper(\Illuminate\Support\Str::uuid())))
                    ->prefixIcon('heroicon-o-key')
                    ->required()
                    ->label('License Key'),
                Select::make('duration')
                    ->options(array_combine(
                        array_map(fn($case) => $case->name, CodeDuration::cases()),
                        array_map(fn($case) => $case->value, CodeDuration::cases())
                    ))
                    ->default(CodeDuration::MONTH->value)
                    ->required()
                    ->in(array_map(fn($case) => $case->name, CodeDuration::cases())),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->formatStateUsing(function($state){
                        return sprintf("%s........%s", Str::substr(Crypt::decrypt($state), 0, 4), Str::substr(Crypt::decrypt($state), -4));
                    }),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        CodeStatus::UNUSED->name => Color::Blue,
                        CodeStatus::ACTIVE->name => Color::Green,
                        default => Color::Red,
                    }),
                TextColumn::make('duration')
                    ->badge()
                    ->formatStateUsing(fn($state) => Str::replace('_', ' ', $state))

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(array_combine(
                        array_map(fn($case) => $case->name, CodeStatus::cases()),
                        array_map(fn($case) => $case->value, CodeStatus::cases())
                    ))
                    ->multiple()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('copy')
                    ->label('Copy')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function($livewire, $record){
                        try{
                            $livewire->js('navigator.clipboard.writeText("'.Crypt::decrypt($record->code).'")');
                            Notification::make()
                            ->title('Success')
                            ->body('License key copied to clipboard')
                            ->send();

                        }catch(Exception $e){
                            Notification::make()
                                ->title('Error')
                                ->body($e->getMessage())
                                ->send();
                        }

                        
                    })
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
            'index' => Pages\ListCodes::route('/'),
            'create' => Pages\CreateCode::route('/create'),
            'edit' => Pages\EditCode::route('/{record}/edit'),
        ];
    }
}
