<?php

namespace App\Filament\Resources\CallUsResource\Pages;

use App\Filament\Resources\CallUsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCallUs extends ListRecords
{
    protected static string $resource = CallUsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
