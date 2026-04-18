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
                    ->label('العنوان (مثلاً: سنوات الخبرة)')
                    ->required(),
                TextInput::make('value')
                    ->label('القيمة (مثلاً: +10)')
                    ->required(),
            ]);
    }
}
