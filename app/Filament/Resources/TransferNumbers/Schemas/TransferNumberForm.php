<?php

namespace App\Filament\Resources\TransferNumbers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransferNumberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Transfer Method'))
                    ->placeholder(__('e.g. Vodafone Cash, InstaPay, ...'))
                    ->required(),
                TextInput::make('number')
                    ->label(__('Number'))
                    ->required(),
            ]);
    }
}
