<?php

namespace App\Filament\Resources;

use App\Models\Modele;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\ModeleResource\Pages;

class ModeleResource extends Resource
{
    protected static ?string $model = Modele::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('marque_id')
                        ->rules(['exists:marques,id'])
                        ->required()
                        ->relationship('marque', 'name')
                        ->searchable()
                        ->placeholder('Marque')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('marque.name')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('marque_id')
                    ->relationship('marque', 'name')
                    ->indicator('Marque')
                    ->multiple()
                    ->label('Marque'),
            ]);
    }

    public static function getRelations(): array
    {
        return [ModeleResource\RelationManagers\VersionsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModeles::route('/'),
            'create' => Pages\CreateModele::route('/create'),
            'view' => Pages\ViewModele::route('/{record}'),
            'edit' => Pages\EditModele::route('/{record}/edit'),
        ];
    }
}
