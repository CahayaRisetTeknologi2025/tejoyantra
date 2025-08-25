<?php

namespace App\Filament\Resources\Towers\Widgets;

use App\Models\Tower;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TowerOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';
    protected function getStats(): array
    {
        return [
            Stat::make(
                label: 'Total Tower',
                value: Tower::all()->count(),
            ),
            Stat::make(
                label: 'Total Tower Active',
                value: Tower::active()->count(),
            ),
            Stat::make(
                label: 'Total Tower Inactive',
                value: Tower::notActive()->count(),
            )
        ];
    }
}
