<?php

namespace App\Filament\Pages;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Carbon\Carbon;

class AppointmentSchedule extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected string $view = 'filament.pages.appointment-schedule';

    public static function getNavigationGroup(): ?string
    {
        return __('Appointment Management');
    }
    
    protected static ?int $navigationSort = 0;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'date' => now()->format('Y-m-d'),
            'branch_id' => Branch::first()?->id,
            'specialist_ids' => [],
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
                            ->placeholder(__('All Branches'))
                            ->live(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function getScheduleData(): array
    {
        $date = $this->data['date'] ?? now()->format('Y-m-d');
        $branchId = $this->data['branch_id'] ?? null;

        // Fetch ALL specialists
        $specialists = User::where('type', 'specialist')->get();

        // Fetch appointments for this date
        $appointmentsQuery = Appointment::with(['specialist', 'bookinMonthly.booking'])
            ->where('date', $date);

        if ($branchId) {
            $appointmentsQuery->whereHas('day', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            });
        }
        
        $appointments = $appointmentsQuery->get();

        // Define times (Hours: 10 AM to 5 PM)
        $times = [
            '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00'
        ];

        $matrix = [];
        foreach ($appointments as $appointment) {
            // Standardize appointment time to match our grid $times (H:00:00)
            $timeKey = date('H:00:00', strtotime($appointment->time));
            
            $childName = $appointment->bookinMonthly?->booking?->child_name;
            
            if ($childName) {
                $matrix[$timeKey][$appointment->specialist_id] = $childName;
            }
        }

        return [
            'specialists' => $specialists,
            'times' => $times,
            'matrix' => $matrix,
        ];
    }
}
