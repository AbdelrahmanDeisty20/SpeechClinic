<?php

namespace App\Filament\Resources\CostResource\Pages;

use App\Filament\Resources\CostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCost extends CreateRecord
{
    protected static string $resource = CostResource::class;

    public function getTitle(): string
    {
        return __('Create Cost');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = 'General';
        return $data;
    }
}
