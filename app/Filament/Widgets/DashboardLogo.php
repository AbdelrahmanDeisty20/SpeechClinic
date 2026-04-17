<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardLogo extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-logo';

    protected static ?int $sort = 0;

    protected int | string | array $columnSpan = 'full';
}
