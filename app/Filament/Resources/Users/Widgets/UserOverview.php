<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            Stat::make(
                label: 'Total User',
                value: User::all()->count(),
            ),
            Stat::make(
                label: 'Total Active User',
                value: User::active()->count(),
            ),
            Stat::make(
                label: 'Total Inactive User',
                value: User::notActive()->count(),
            ),
            Stat::make(
                label: 'Total External',
                value: User::role('external')->count(),
            )
        ];
    }
}
