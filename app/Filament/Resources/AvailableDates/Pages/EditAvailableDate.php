<?php

namespace App\Filament\Resources\AvailableDates\Pages;

use App\Filament\Resources\AvailableDates\AvailableDateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAvailableDate extends EditRecord
{
    protected static string $resource = AvailableDateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
