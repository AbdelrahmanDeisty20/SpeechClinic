<?php

namespace App\Filament\Resources\CallUsResource\Pages;

use App\Filament\Resources\CallUsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCallUs extends EditRecord
{
    protected static string $resource = CallUsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
