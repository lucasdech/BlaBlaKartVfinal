<?php

namespace App\Filament\Pages;

use App\Providers\Filament\Widgets\StatsOverviewWidget as WidgetsStatsOverviewWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            WidgetsStatsOverviewWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 1;
    }
}