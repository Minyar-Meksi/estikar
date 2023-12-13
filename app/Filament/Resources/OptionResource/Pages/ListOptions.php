<?php

namespace App\Filament\Resources\OptionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\OptionResource;
use App\Filament\Traits\HasDescendingOrder;

class ListOptions extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = OptionResource::class;
}
