<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPage extends ListRecords
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('الصفحات');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('صفحة جديدة'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
