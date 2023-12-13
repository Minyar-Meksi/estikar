<?php

namespace App\Filament\Resources\MarqueResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\MarqueResource;
use App\Filament\Traits\HasDescendingOrder;

class ListMarques extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = MarqueResource::class;
}
