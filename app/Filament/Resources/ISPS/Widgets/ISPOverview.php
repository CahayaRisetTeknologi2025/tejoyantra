<?php

namespace App\Filament\Resources\ISPS\Widgets;

use App\Models\ISP;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ISPOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';
    protected function getStats(): array
    {
        return [
            Stat::make(
                label: 'Total ISP',
                value: ISP::all()->count(),
            ),
            Stat::make(
                label: 'Total ISP Active',
                value: ISP::active()->count(),
            ),
            Stat::make(
                label: 'Total ISP Inactive',
                value: ISP::notActive()->count(),
            )
        ];
    }
}
