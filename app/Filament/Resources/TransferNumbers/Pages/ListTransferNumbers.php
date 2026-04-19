<?php

namespace App\Filament\Resources\TransferNumbers\Pages;

use App\Filament\Resources\TransferNumbers\TransferNumberResource;
use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransferNumbers extends ListRecords
{
    protected static string $resource = TransferNumberResource::class;

    public function getTitle(): string
    {
        return __('أرقام التحويل');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('إضافة رقم تحويل جديد')),
        ];
    }
}
