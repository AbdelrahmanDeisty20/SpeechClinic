<?php

namespace App\Filament\Resources\BookinMonthlyResource\Pages;

use App\Filament\Resources\BookinMonthlyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookinMonthly extends EditRecord
{
    protected static string $resource = BookinMonthlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
