<?php

namespace App\Filament\Resources\TransferNumbers\Pages;

use App\Filament\Resources\TransferNumbers\TransferNumberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransferNumber extends EditRecord
{
    protected static string $resource = TransferNumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
