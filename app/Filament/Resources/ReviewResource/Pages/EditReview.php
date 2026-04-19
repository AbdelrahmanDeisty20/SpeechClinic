<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    public function getTitle(): string
    {
        return __('Edit Review');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->label(__('View')),
            Actions\DeleteAction::make()->label(__('Delete')),
        ];
    }
}
