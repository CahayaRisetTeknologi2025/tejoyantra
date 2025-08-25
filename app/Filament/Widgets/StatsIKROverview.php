<?php

namespace App\Filament\Widgets;

use App\Models\IKRInstallation;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsIKROverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        return [
            Stat::make('Total IKR', IKRInstallation::count())
                ->description('Total IKR')
                ->color('success')
                ->chart([7,2,10,3,15,4,17,10,25,24]),

            Stat::make(
                label: 'Total IKR Garansi',
                value: IKRInstallation::ikrWarranty()->count(),
            )
            ->description('Total IKR Garansi')
            ->color('primary')
            ->chart([3, 5, 8, 12, 9, 15, 7]),

            Stat::make(
                label: 'Total IKR Expired',
                value: IKRInstallation::ikrExpired()->count(),
            )
            ->description('Total IKR Expired')
            ->color('danger')
            ->chart([10, 15, 12, 18, 20, 25, 22]),
        ];
    }
}
