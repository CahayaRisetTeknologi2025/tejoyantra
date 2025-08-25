<?php

namespace App\Filament\Widgets;

use App\Models\IKRInstallation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class IKRStatusChart extends ChartWidget
{
    protected ?string $heading = 'Status per Month';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = IKRInstallation::select(
            DB::raw('MONTH(installation_date) as month'),
            DB::raw('COUNT(*) as total'),
            'status'
        )
            ->whereBetween('installation_date', [
                now()->startOfYear(),
                now()->endOfYear()
            ])
            ->groupBy('month', 'status')
            ->orderBy('month')
            ->get();

        $datasets = [];
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $statuses = ['PENDING', 'DONE', 'CANCEL'];
        $colors = ['#FFCE56', '#36A2EB', '#FF6384'];

        foreach ($statuses as $index => $status) {
            $dataset = array_fill(0,12,0);

            foreach($data as $item){
                if ($item->status == $status) {
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
