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
            Actions\Action::make('confirm')
                ->label(__('Confirm'))
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update(['status' => 'confirmed']))
                ->visible(fn ($record) => $record->status === 'accepted'),

            Actions\Action::make('complete')
                ->label(__('Completed'))
                ->icon('heroicon-o-check-badge')
                ->color('gray')
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update(['status' => 'completed']))
                ->visible(fn ($record) => $record->status === 'confirmed'),

            Actions\Action::make('cancel')
                ->label(__('Cancelled'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update(['status' => 'pending']))
                ->visible(fn ($record) => in_array($record->status, ['pending', 'accepted', 'confirmed'])),

            Actions\EditAction::make()->label(__('تعديل')),
        ];
    }
}
