<?php

namespace App\Filament\Resources\CostResource\Pages;

use App\Filament\Resources\CostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCosts extends ListRecords
{
    protected static string $resource = CostResource::class;

    public function getTitle(): string
    {
        return __('التكاليف والأسعار');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('سعر جديد')),
        ];
    }
}
