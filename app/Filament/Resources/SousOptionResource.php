<?php

namespace App\Filament\Resources;

use App\Models\SousOption;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\SousOptionResource\Pages;

class SousOptionResource extends Resource
{
    protected static ?string $model = SousOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('option_id')
                        ->rules(['exists:options,id'])
                        ->required()
                        ->relationship('option', 'name')
                        ->searchable()
                        ->placeholder('Option')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('price')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Price')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
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
                Tables\Columns\TextColumn::make('option.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('price')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('option_id')
                    ->relationship('option', 'name')
                    ->indicator('Option')
                    ->multiple()
                    ->label('Option'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSousOptions::route('/'),
            'create' => Pages\CreateSousOption::route('/create'),
            'view' => Pages\ViewSousOption::route('/{record}'),
            'edit' => Pages\EditSousOption::route('/{record}/edit'),
        ];
    }
}
