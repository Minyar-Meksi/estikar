<?php

namespace App\Filament\Resources\SousOptionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\SousOptionResource;

class ListSousOptions extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = SousOptionResource::class;
}
