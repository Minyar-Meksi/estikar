<?php

namespace App\Filament\Resources\CategorieResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\CategorieResource;

class ListCategories extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = CategorieResource::class;
}
