<?php

namespace App\Filament\Resources\AppNotificationResource\Pages;

use App\Filament\Resources\AppNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAppNotification extends CreateRecord
{
    protected static string $resource = AppNotificationResource::class;

    public function getTitle(): string
    {
        return __('Send New Notification');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
