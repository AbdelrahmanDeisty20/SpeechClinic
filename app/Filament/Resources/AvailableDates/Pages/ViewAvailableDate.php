<?php

namespace App\Filament\Resources\AvailableDates\Pages;

use App\Filament\Resources\AvailableDates\AvailableDateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAvailableDate extends ViewRecord
{
    protected static string $resource = AvailableDateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
