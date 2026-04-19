<?php

namespace App\Filament\Resources\CallUsResource\Pages;

use App\Filament\Resources\CallUsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCallUs extends CreateRecord
{
    protected static string $resource = CallUsResource::class;

    public function getTitle(): string
    {
        return __('Create Call Request');
    }
}
