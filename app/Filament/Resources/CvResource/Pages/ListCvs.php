<?php

namespace App\Filament\Resources\CvResource\Pages;

use App\Filament\Resources\CvResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCvs extends ListRecords
{
    protected static string $resource = CvResource::class;

    public function getTitle(): string
    {
        return __('السير الذاتية');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('سيرة ذاتية جديدة'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
