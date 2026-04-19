<?php

namespace App\Filament\Resources\CallUsResource\Pages;

use App\Filament\Resources\CallUsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCallUs extends ListRecords
{
    protected static string $resource = CallUsResource::class;

    public function getTitle(): string
    {
        return __('طلبات "اتصل بنا"');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('طلب اتصال جديد')),
        ];
    }
}
