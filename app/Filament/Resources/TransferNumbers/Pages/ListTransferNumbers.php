<?php

namespace App\Filament\Resources\TransferNumbers\Pages;

use App\Filament\Resources\TransferNumbers\TransferNumberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransferNumbers extends ListRecords
{
    protected static string $resource = TransferNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
