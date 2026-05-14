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
                \Filament\Schemas\Components\Section::make(__('Date Information'))
                    ->columns(2)
                    ->schema([
                        DatePicker::make('date')
                            ->label(__('Date'))
                            ->required()
                            ->live(),
                        \Filament\Forms\Components\Select::make('day_id')
                            ->label(__('Day'))
                            ->relationship('day', 'name_en')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->branch?->name})")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),
                    ]),

                \Filament\Schemas\Components\Section::make(__('Available Time Slots'))
                    ->description(__('Add specific time slots and limits for this date.'))
                    ->schema([
                        \Filament\Forms\Components\Repeater::make('availableTimes')
                            ->relationship('availableTimes')
                            ->schema([
                                \Filament\Forms\Components\TimePicker::make('from')
                                    ->label(__('From'))
                                    ->seconds(false)
                                    ->required(),
                                \Filament\Forms\Components\TimePicker::make('to')
                                    ->label(__('To'))
                                    ->seconds(false)
                                    ->required(),
                                TextInput::make('limit')
                                    ->label(__('Limit'))
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                \Filament\Forms\Components\Hidden::make('type')
                                    ->default('assessment'),
                                \Filament\Forms\Components\Hidden::make('day_id')
                                    ->default(fn (\Filament\Schemas\Components\Utilities\Get $get) => $get('../../day_id')),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->reorderableWithButtons()
                            ->label(__('Slots'))
                            ->addActionLabel(__('Add New Slot')),
                    ]),
            ]);
    }
}
