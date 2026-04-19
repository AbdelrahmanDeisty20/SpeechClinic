<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('Experience Title'))
                    ->placeholder(__('e.g. Years of Experience'))
                    ->required(),
                TextInput::make('value')
                    ->label(__('Experience Value'))
                    ->placeholder(__('e.g. +10'))
                    ->required(),
            ]);
    }
}
