<?php

namespace App\Filament\Resources\AvailableDates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AvailableDateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label(__('Date'))
                    ->required(),
                \Filament\Forms\Components\Select::make('day_id')
                    ->label(__('Day'))
                    ->relationship('day', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->branch?->name})")
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
