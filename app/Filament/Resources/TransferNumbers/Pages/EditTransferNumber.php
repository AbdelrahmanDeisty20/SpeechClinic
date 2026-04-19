<?php

namespace App\Filament\Resources\TransferNumbers\Pages;

use App\Filament\Resources\TransferNumbers\TransferNumberResource;
use Filament\Actions\DeleteAction;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransferNumber extends EditRecord
{
    protected static string $resource = TransferNumberResource::class;

    public function getTitle(): string
    {
        return __('Edit Transfer Number');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label(__('Delete')),
        ];
    }
}
