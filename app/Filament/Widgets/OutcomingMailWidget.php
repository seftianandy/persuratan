<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\OutcomingMail;
use Carbon\Carbon;

class OutcomingMailWidget extends ChartWidget
{
    protected static ?string $heading = 'Suarat Keluar';

    protected static string $color = 'info';


    protected function getFilters(): ?array
    {
        $years = OutcomingMail::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year', 'year')
            ->toArray();

        if (empty($years)) {
            $years = [Carbon::now()->year => Carbon::now()->year];
        }

        return $years;
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        if (! $activeFilter) {
            $activeFilter = Carbon::now()->year;
        }

        $monthlyCounts = OutcomingMail::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->whereYear('date', $activeFilter)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $data = array_fill(1, 12, 0);
        foreach ($monthlyCounts as $month => $count) {
            $data[$month] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Surat Keluar',
                    'data' => array_values($data),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getDescription(): ?string
    {
        return 'Data ini diambil dari data surat keluar yang telah tercatat di sistem.';
    }
}
