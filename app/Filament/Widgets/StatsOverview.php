<?php

namespace App\Filament\Widgets;

use App\Models\Banner;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Cv;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Assessment Bookings', Booking::where('type', 'assessment')->count())
                ->description('Initial evaluations')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            Stat::make('Monthly Bookings', Booking::where('type', 'monthly')->count())
                ->description('Ongoing sessions')
                ->descriptionIcon('heroicon-m-calendar-date-range')
                ->color('success'),
            Stat::make('Pending Bookings', Booking::where('status', 'pending')->count())
                ->description('Awaiting confirmation')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Total Users', User::count())
                ->description('Registered staff & clients')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
        ];
    }
}
