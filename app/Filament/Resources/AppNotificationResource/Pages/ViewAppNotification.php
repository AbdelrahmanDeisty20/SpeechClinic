<?php

namespace App\Filament\Resources\AppNotificationResource\Pages;

use App\Filament\Resources\AppNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAppNotification extends ViewRecord
{
    protected static string $resource = AppNotificationResource::class;

    public function getTitle(): string
    {
        return __('تفاصيل الإشعار');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
