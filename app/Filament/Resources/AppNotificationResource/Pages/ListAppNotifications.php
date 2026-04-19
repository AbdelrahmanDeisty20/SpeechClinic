<?php

namespace App\Filament\Resources\AppNotificationResource\Pages;

use App\Filament\Resources\AppNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppNotifications extends ListRecords
{
    protected static string $resource = AppNotificationResource::class;

    public function getTitle(): string
    {
        return __('إشعارات التطبيق');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('إرسال إشعار جديد')),
        ];
    }
}
