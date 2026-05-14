<?php

namespace App\Filament\Resources\AvailableDates\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AvailableDateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('day_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
