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
                    ->label('الوسيلة (فودافون كاش / انستا باي / الخ)')
                    ->required(),
                TextInput::make('number')
                    ->label('الرقم')
                    ->required(),
            ]);
    }
}
