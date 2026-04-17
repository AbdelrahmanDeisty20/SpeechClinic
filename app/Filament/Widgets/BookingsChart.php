<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BookingsChart extends ChartWidget
{
    public function getHeading(): string
    {
        return __('Bookings count per month');
    }

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Simple count by day for the last 30 days
        // Note: If Trend package is not installed, we can fall back to manual query
        // For now, I will use a manual query to avoid dependency issues if Trend is not there.
        
        $data = Booking::selectRaw('DATE(created_at) as date, count(*) as aggregate')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('Bookings'),
                    'data' => $data->map(fn ($value) => $value->aggregate),
                    'borderColor' => '#3b82f6',
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
            ],
            'labels' => $data->map(fn ($value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
