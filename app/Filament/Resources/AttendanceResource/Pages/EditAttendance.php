<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendance extends EditRecord
{
    protected static string $resource = AttendanceResource::class;

    public function getTitle(): string
    {
        return __('Edit Attendance Record');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label(__('Delete')),
        ];
    }
}
