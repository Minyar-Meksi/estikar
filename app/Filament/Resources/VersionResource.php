<?php

namespace App\Filament\Resources;

use App\Models\Version;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\VersionResource\Pages;

class VersionResource extends Resource
{
    protected static ?string $model = Version::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $shouldRegisterNavigation = true;

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

                    Select::make('modele_id')
                        ->rules(['exists:modeles,id'])
                        ->required()
                        ->relationship('modele', 'name')
                        ->searchable()
                        ->placeholder('Modele')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('picture')
                        ->rules(['image', 'max:1024'])
                        ->nullable()
                        ->image()
                        ->placeholder('Picture')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('year')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Year')
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
                Tables\Columns\TextColumn::make('modele.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\ImageColumn::make('picture')
                    ->toggleable()
                    ->circular(),
                Tables\Columns\TextColumn::make('year')
                    ->toggleable()
                    ->searchable(true, null, true),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('modele_id')
                    ->relationship('modele', 'name')
                    ->indicator('Modele')
                    ->multiple()
                    ->label('Modele'),
            ]);
    }

    public static function getRelations(): array
    {
        return [VersionResource\RelationManagers\OptionsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVersions::route('/'),
            'create' => Pages\CreateVersion::route('/create'),
            'view' => Pages\ViewVersion::route('/{record}'),
            'edit' => Pages\EditVersion::route('/{record}/edit'),
        ];
    }
}
