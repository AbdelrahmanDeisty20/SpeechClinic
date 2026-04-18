<?php

namespace App\Filament\Resources\BookinMonthlyResource\Pages;

use App\Filament\Resources\BookinMonthlyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBookinMonthly extends ViewRecord
{
    protected static string $resource = BookinMonthlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
