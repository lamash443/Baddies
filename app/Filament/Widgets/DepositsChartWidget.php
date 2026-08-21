<?php

namespace App\Filament\Widgets;

use App\Models\Deposit;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class DepositsChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Daily Deposits';

    protected ?string $description = 'Total completed deposit amounts per day';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '320px';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7'  => 'Last 7 days',
            '14' => 'Last 14 days',
            '30' => 'Last 30 days',
            '90' => 'Last 90 days',
        ];
    }

    protected function getData(): array
    {
        $days = (int) ($this->filter ?? 30);

        $start = Carbon::now()->subDays($days - 1)->startOfDay();

        // Build a full date range so days with zero deposits still appear
        $dateRange = collect();
        for ($i = 0; $i < $days; $i++) {
            $dateRange->put(
                Carbon::now()->subDays($days - 1 - $i)->toDateString(),
                0
            );
        }

        // Fetch completed deposits grouped by day
        $deposits = Deposit::query()
            ->where('status', 'completed')
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Merge — days with no deposits stay at 0
        $merged = $dateRange->merge($deposits);

        $labels = $merged->keys()->map(fn ($date) => Carbon::parse($date)->format('M d'))->toArray();
        $data   = $merged->values()->map(fn ($v) => round((float) $v, 2))->toArray();

        return [
            'datasets' => [
                [
                    'label'                => 'Deposits (KSh)',
                    'data'                 => $data,
                    'fill'                 => true,
                    'backgroundColor'      => 'rgba(251, 191, 36, 0.12)',
                    'borderColor'          => 'rgba(251, 191, 36, 1)',
                    'borderWidth'          => 2.5,
                    'pointBackgroundColor' => 'rgba(251, 191, 36, 1)',
                    'pointBorderColor'     => '#fff',
                    'pointBorderWidth'     => 2,
                    'pointRadius'          => 4,
                    'pointHoverRadius'     => 7,
                    'tension'              => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display'  => true,
                    'position' => 'top',
                    'labels'   => [
                        'usePointStyle' => true,
                        'pointStyle'    => 'circle',
                        'padding'       => 20,
                    ],
                ],
                'tooltip' => [
                    'mode'      => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid'  => ['display' => false],
                    'ticks' => ['maxTicksLimit' => 10],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid'        => ['color' => 'rgba(0,0,0,0.05)'],
                ],
            ],
            'interaction' => [
                'mode'      => 'nearest',
                'axis'      => 'x',
                'intersect' => false,
            ],
        ];
    }
}
