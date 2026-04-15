<?php

namespace App\Filament\Widgets;

use App\Models\Banner;
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
            Stat::make('Total Users', User::count())
                ->description('Registered staff & clients')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Active Banners', Banner::count())
                ->description('Visual promotions')
                ->descriptionIcon('heroicon-m-photo')
                ->color('info'),
            Stat::make('Network Branches', Branch::count())
                ->description('Physical locations')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('warning'),
            Stat::make('CV Applications', Cv::count())
                ->description('Pending resumes')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart([1, 5, 2, 10, 5, 20])
                ->color('primary'),
        ];
    }
}
