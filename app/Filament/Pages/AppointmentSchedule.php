<?php

namespace App\Filament\Pages;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Carbon\Carbon;

class AppointmentSchedule extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected string $view = 'filament.pages.appointment-schedule';

    protected static string|\UnitEnum|null $navigationGroup = 'Appointments Management';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'date' => now()->format('Y-m-d'),
            'branch_id' => Branch::first()?->id,
        ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('Sessions Schedule');
    }

    public function getTitle(): string
    {
        return __('Sessions Schedule');
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        DatePicker::make('date')
                            ->label(__('Date'))
                            ->live()
                            ->required(),
                        Select::make('branch_id')
                            ->label(__('Branch'))
                            ->options(Branch::all()->pluck('name', 'id'))
                            ->live()
                            ->required(),
                        Select::make('specialist_ids')
                            ->label(__('Filter Specialists'))
                            ->options(User::where('type', 'specialist')->get()->pluck('full_name', 'id'))
                            ->multiple()
                            ->placeholder(__('All Specialists'))
                            ->live()
                            ->columnSpanFull(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function getHeaderWidgets(): array
    {
        return [];
    }

    public function getScheduleData(): array
    {
        $date = $this->data['date'] ?? now()->format('Y-m-d');
        $branchId = $this->data['branch_id'] ?? null;
        $selectedSpecialistIds = $this->data['specialist_ids'] ?? [];

        if (!$branchId) {
            return [
                'specialists' => [],
                'times' => [],
                'matrix' => [],
            ];
        }

        // Fetch specialists
        $specialistsQuery = User::where('type', 'specialist');
        
        if (!empty($selectedSpecialistIds)) {
            $specialistsQuery->whereIn('id', $selectedSpecialistIds);
        }
        
        $specialists = $specialistsQuery->get();

        // Fetch appointments for this date and branch
        $appointments = Appointment::with(['specialist', 'bookinMonthly.booking'])
            ->where('date', $date)
            ->whereHas('bookinMonthly.booking.availableTime.day', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->get();

        // Define times (Hours)
        $times = [
            '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00'
        ];

        $matrix = [];
        foreach ($appointments as $appointment) {
            // Standardize appointment time to match our grid $times
            $timeKey = date('H:00:00', strtotime($appointment->time));
            
            $matrix[$timeKey][$appointment->specialist_id] = $appointment->bookinMonthly?->booking?->child_name ?? '-';
        }

        return [
            'specialists' => $specialists,
            'times' => $times,
            'matrix' => $matrix,
        ];
    }
}
