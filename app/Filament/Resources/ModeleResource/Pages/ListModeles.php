<?php

namespace App\Filament\Resources\ModeleResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ModeleResource;
use App\Filament\Traits\HasDescendingOrder;

class ListModeles extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ModeleResource::class;
}
