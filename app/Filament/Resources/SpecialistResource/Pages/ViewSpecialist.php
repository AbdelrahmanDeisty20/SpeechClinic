<?php

namespace App\Filament\Resources\SpecialistResource\Pages;

use App\Filament\Resources\SpecialistResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSpecialist extends ViewRecord
{
    protected static string $resource = SpecialistResource::class;

    public function getTitle(): string
    {
        return __('ملف الأخصائي');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label(__('تعديل')),
        ];
    }
}
