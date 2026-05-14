<?php

namespace App\Filament\Resources\AvailableDates\Pages;

use App\Filament\Resources\AvailableDates\AvailableDateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAvailableDates extends ListRecords
{
    protected static string $resource = AvailableDateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
