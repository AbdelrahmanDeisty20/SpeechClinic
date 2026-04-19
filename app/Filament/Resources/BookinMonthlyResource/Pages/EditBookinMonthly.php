<?php

namespace App\Filament\Resources\BookinMonthlyResource\Pages;

use App\Filament\Resources\BookinMonthlyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookinMonthly extends EditRecord
{
    protected static string $resource = BookinMonthlyResource::class;

    public function getTitle(): string
    {
        return __('Edit Monthly Booking');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->label(__('View')),
            Actions\DeleteAction::make()->label(__('Delete')),
        ];
    }
}
