<?php

namespace App\Filament\Widgets;

use App\Models\IKRInstallation;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class IKRStatusWorkChart extends ChartWidget
{
    protected ?string $heading = 'Work Status per Month';
    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = IKRInstallation::select(
            DB::raw('MONTH(installation_date) as month'),
            DB::raw('COUNT(*) as total'),
            'status_work'
        )
        ->whereBetween('installation_date', [
            now()->startOfYear(),
            now()->endOfYear()
        ])
        ->groupBy('month', 'status_work')
        ->orderBy('month')
        ->get();

        $datasets = [];
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $statuses = ['MIGRASI', 'INSTALASI', 'TROUBLESHOOTING', 'RELOKASI'];
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'];

        foreach ($statuses as $index => $status) {
            $dataset = array_fill(0,12,0);

            foreach($data as $item){
                if ($item->status_work == $status) {
                    $dataset[$item->month - 1] = $item->total;
                }
            }

            $datasets[] = [
                'label' => $status,
                'data' => $dataset,
                'backgroundColor' => $colors[$index],
                'borderColor' => $colors[$index],
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
