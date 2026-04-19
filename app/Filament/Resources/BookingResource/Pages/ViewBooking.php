<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;

    public function getTitle(): string
    {
        return __('تفاصيل الحجز');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label(__('تعديل')),
        ];
    }
}
