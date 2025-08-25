<?php

namespace App\Filament\Resources\Buildings\Widgets;

use App\Models\Building;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BuildingOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';
    protected function getStats(): array
    {
        return [
            Stat::make(
                label: 'Total Building',
                value: Building::all()->count(),
            ),
            Stat::make(
                label: 'Total Building Active',
                value: Building::active()->count(),
            ),
            Stat::make(
                label: 'Total Building Inactive',
                value: Building::notActive()->count(),
            )
        ];
    }
}
