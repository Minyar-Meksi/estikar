<?php

namespace App\Filament\Resources\FeedbackResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\FeedbackResource;

class ListFeedbacks extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = FeedbackResource::class;
}
