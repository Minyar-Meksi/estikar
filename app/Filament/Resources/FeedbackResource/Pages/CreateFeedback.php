<?php

namespace App\Filament\Resources\FeedbackResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\FeedbackResource;

class CreateFeedback extends CreateRecord
{
    protected static string $resource = FeedbackResource::class;
}
