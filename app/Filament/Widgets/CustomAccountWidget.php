<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CustomAccountWidget extends Widget
{
    protected string $view = 'filament.widgets.custom-account-widget';

    protected static ?int $sort = -1;

    protected int | string | array $columnSpan = [
        'default' => 1,
        'sm' => 1,
        'md' => 1,
        'lg' => 1,
        'xl' => 1,
        '2xl' => 1,
    ];
}
