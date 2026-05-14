<?php

namespace App\Filament\Resources\AvailableTimeResource\Pages;

use App\Filament\Resources\AvailableTimeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAvailableTimes extends ListRecords
{
    protected static string $resource = AvailableTimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('batchCreate')
                ->label(__('Batch Create Slots'))
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->form([
                    \Filament\Schemas\Components\Grid::make(3)
                        ->schema([
                            \Filament\Forms\Components\Select::make('date_id')
                                ->label(__('Date'))
                                ->options(\App\Models\AvailableDate::all()->mapWithKeys(fn($d) => [$d->id => "{$d->date} - {$d->day?->name} ({$d->day?->branch?->name})"]))
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $date = \App\Models\AvailableDate::find($state);
                                        $set('day_id', $date?->day_id);
                                    }
                                }),
                            \Filament\Forms\Components\Hidden::make('day_id'),
                            \Filament\Forms\Components\TimePicker::make('start_time')
                                ->label(__('Start Time'))
                                ->default('08:00:00')
                                ->required()
                                ->live(),
                            \Filament\Forms\Components\TimePicker::make('end_time')
                                ->label(__('End Time'))
                                ->default('16:00:00')
                                ->required()
                                ->live(),
                            \Filament\Forms\Components\TextInput::make('interval')
                                ->label(__('Interval (Minutes)'))
                                ->numeric()
                                ->default(60)
                                ->required()
                                ->live(),
                            \Filament\Forms\Components\TextInput::make('default_limit')
                                ->label(__('Default Limit'))
                                ->numeric()
                                ->default(1)
                                ->required()
                                ->live(),
                        ]),
                    \Filament\Schemas\Components\Actions::make([
                        \Filament\Schemas\Components\Actions\Action::make('generate')
                            ->label(__('Generate Slots'))
                            ->button()
                            ->color('info')
                            ->action(function (callable $set, $get) {
                                $startStr = $get('start_time');
                                $endStr = $get('end_time');
                                if (!$startStr || !$endStr) return;

                                $start = \Carbon\Carbon::parse($startStr);
                                $end = \Carbon\Carbon::parse($endStr);
                                $interval = (int) ($get('interval') ?? 60);
                                $limit = (int) ($get('default_limit') ?? 1);

                                if ($end->lte($start)) {
                                    \Filament\Notifications\Notification::make()
                                        ->danger()
                                        ->title('End time must be after start time')
                                        ->send();
                                    return;
                                }

                                $slots = [];
                                while ($start->lt($end)) {
                                    $slots[] = [
                                        'time' => $start->format('H:i:s'),
                                        'limit' => $limit,
                                    ];
                                    $start->addMinutes($interval);
                                }
                                $set('slots', $slots);
                            })
                    ]),
                    \Filament\Forms\Components\Repeater::make('slots')
                        ->label(__('Review Slots'))
                        ->schema([
                            \Filament\Forms\Components\TimePicker::make('time')->label(__('Time'))->required(),
                            \Filament\Forms\Components\TextInput::make('limit')->label(__('Limit'))->numeric()->required(),
                        ])
                        ->columns(2)
                        ->grid(1)
                ])
                ->modalWidth('4xl')
                ->action(function (array $data) {
                    if (empty($data['slots'])) return;

                    foreach ($data['slots'] as $slot) {
                        \App\Models\AvailableTime::create([
                            'date_id' => $data['date_id'],
                            'day_id' => $data['day_id'],
                            'time' => $slot['time'],
                            'limit' => $slot['limit'],
                            'type' => 'assessment',
                        ]);
                    }
                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title(__('Slots created successfully'))
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
