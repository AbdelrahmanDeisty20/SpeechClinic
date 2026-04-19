<?php

namespace App\Filament\Resources\Experiences\Pages;

use App\Filament\Resources\Experiences\ExperienceResource;
use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExperiences extends ListRecords
{
    protected static string $resource = ExperienceResource::class;

    public function getTitle(): string
    {
        return __('إحصائيات الخبرة');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('إضافة إحصائية جديدة')),
        ];
    }
}
