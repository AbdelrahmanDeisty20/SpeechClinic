<?php

namespace App\Filament\Resources\SpecialistResource\Pages;

use App\Filament\Resources\SpecialistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpecialists extends ListRecords
{
    protected static string $resource = SpecialistResource::class;

    public function getTitle(): string
    {
        return __('الأخصائيين');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('أخصائي جديد')),
        ];
    }
}
