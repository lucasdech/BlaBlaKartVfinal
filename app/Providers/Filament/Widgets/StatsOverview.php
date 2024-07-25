<?php

namespace App\Providers\Filament\Widgets;

use App\Models\User;
use App\Models\Trip;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Number of registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Total Trips', Trip::count())
                ->description('Number of all trips')
                ->descriptionIcon('heroicon-m-map')
                ->color('warning'),
            Stat::make('Trips Today', Trip::whereDate('starting_at', today())->count())
                ->description('Trips starting today')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('danger'),
        ];
    }
}