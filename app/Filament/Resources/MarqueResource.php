<?php

namespace App\Filament\Resources;

use App\Models\Marque;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\MarqueResource\Pages;

class MarqueResource extends Resource
{
    protected static ?string $model = Marque::class;

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

                    Select::make('categorie_id')
                        ->rules(['exists:categories,id'])
                        ->required()
                        ->relationship('categorie', 'name')
                        ->searchable()
                        ->placeholder('Categorie')
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
                Tables\Columns\TextColumn::make('categorie.name')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('categorie_id')
                    ->relationship('categorie', 'name')
                    ->indicator('Categorie')
                    ->multiple()
                    ->label('Categorie'),
            ]);
    }

    public static function getRelations(): array
    {
        return [MarqueResource\RelationManagers\ModelesRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarques::route('/'),
            'create' => Pages\CreateMarque::route('/create'),
            'view' => Pages\ViewMarque::route('/{record}'),
            'edit' => Pages\EditMarque::route('/{record}/edit'),
        ];
    }
}
