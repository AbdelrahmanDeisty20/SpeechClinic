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
            Stat::make(__('Total Bookings'), Booking::count())
                ->description(__('Total number of bookings'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),
            Stat::make(__('Pending Bookings'), Booking::where('status', 'pending')->count())
                ->description(__('New bookings awaiting confirmation'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make(__('Total Users'), User::count())
                ->description(__('Registered users on the platform'))
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make(__('Total Revenue'), Booking::where('status', 'confirmed')->sum('price') . ' ' . __('ج.م'))
                ->description(__('Revenue from confirmed bookings'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),
            Stat::make(__('Call Requests'), \App\Models\callUs::count())
                ->description(__('Total call back requests'))
                ->descriptionIcon('heroicon-m-phone')
                ->color('primary'),
            Stat::make(__('Average Rating'), \App\Models\Review::avg('rate') ? number_format(\App\Models\Review::avg('rate'), 1) : '0')
                ->description(__('User feedback score'))
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
        ];
    }
}
