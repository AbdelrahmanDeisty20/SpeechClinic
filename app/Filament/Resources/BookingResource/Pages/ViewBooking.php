<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

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
            Actions\SelectAction::make('status')
                ->label(__('الحالة'))
                ->options([
                    'pending' => __('Pending'),
                    'accepted' => __('Accepted'),
                    'confirmed' => __('Confirmed'),
                    'cancelled' => __('Cancelled'),
                    'completed' => __('Completed'),
                ])
                ->action(fn ($record, $data) => $record->update(['status' => $data['value']])),

            Actions\EditAction::make()->label(__('تعديل')),
        ];
    }
}
