<?php

namespace App\Filament\Resources\BookinMonthlyResource\Pages;

use App\Filament\Resources\BookinMonthlyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookinMonthlies extends ListRecords
{
    protected static string $resource = BookinMonthlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
