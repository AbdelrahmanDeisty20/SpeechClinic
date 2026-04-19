<?php

namespace App\Filament\Resources\SpecialistResource\Pages;

use App\Filament\Resources\SpecialistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpecialist extends EditRecord
{
    protected static string $resource = SpecialistResource::class;

    public function getTitle(): string
    {
        return __('Edit Specialist');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->label(__('View')),
            Actions\DeleteAction::make()->label(__('Delete')),
        ];
    }
}
