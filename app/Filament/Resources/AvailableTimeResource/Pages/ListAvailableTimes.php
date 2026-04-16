<?php

namespace App\Filament\Resources\AvailableTimeResource\Pages;

use App\Filament\Resources\AvailableTimeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvailableTimes extends ListRecords
{
    protected static string $resource = AvailableTimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
