<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use App\Services\GeoLocationService;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class SiteStatsOverview extends StatsOverviewWidget
{
    protected string $view = 'filament.widgets.site-stats-overview';

    public string $search = '';

    public function openVisitorsModal(): void
    {
        $this->dispatch('open-modal', id: 'unique-visitors-modal');
    }

    /**
     * Get unique visitors aggregated by IP address.
     */
    public function getUniqueVisitorsProperty(): Collection
    {
        try {
            $hasCountry = Schema::hasColumn('visitors', 'country');
            $hasTime = Schema::hasColumn('visitors', 'total_time_seconds');

            $select = [
                'ip_address',
                'MAX(user_agent) as user_agent',
                'MIN(created_at) as first_visit_at',
                'MAX(COALESCE(last_visit_at, updated_at)) as last_visit_at',
                'SUM(visits_count) as visits_count',
                'MAX(id) as id',
            ];

            if ($hasCountry) {
                $select[] = 'MAX(country) as country';
                $select[] = 'MAX(country_code) as country_code';
                $select[] = 'MAX(city) as city';
                $select[] = 'MAX(region) as region';
            }

            if ($hasTime) {
                $select[] = 'SUM(total_time_seconds) as total_time_seconds';
            }

            $query = Visitor::query();

            if (!empty(trim($this->search))) {
                $term = trim($this->search);
                $query->where(function ($q) use ($term, $hasCountry) {
                    $q->where('ip_address', 'like', "%{$term}%");
                    if ($hasCountry) {
                        $q->orWhere('country', 'like', "%{$term}%")
                          ->orWhere('city', 'like', "%{$term}%");
                    }
                });
            }

            $records = $query
                ->selectRaw(implode(', ', $select))
                ->groupBy('ip_address')
                ->orderByDesc('last_visit_at')
                ->limit(100)
                ->get();

            // Ensure location is populated for records that have null country
            foreach ($records as $visitor) {
                if (empty($visitor->country) && !empty($visitor->ip_address)) {
                    $geo = GeoLocationService::lookup($visitor->ip_address);
                    if (!empty($geo['country'])) {
                        $visitor->country = $geo['country'];
                        $visitor->country_code = $geo['country_code'];
                        $visitor->city = $geo['city'];
                        $visitor->region = $geo['region'];

                        // Update in background if table has columns
                        if ($hasCountry) {
                            try {
                                Visitor::where('ip_address', $visitor->ip_address)
                                    ->whereNull('country')
                                    ->update([
                                        'country' => $geo['country'],
                                        'country_code' => $geo['country_code'],
                                        'city' => $geo['city'],
                                        'region' => $geo['region'],
                                    ]);
                            } catch (\Throwable $e) {}
                        }
                    }
                }
            }

            return $records;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('SiteStatsOverview unique visitors error: ' . $e->getMessage());
            return collect();
        }
    }

    protected function getStats(): array
    {
        try {
            $totalUniqueVisitors = Visitor::distinct('ip_address')->count('ip_address');
            $todayUniqueVisitors = Visitor::whereDate('visit_date', today())->distinct('ip_address')->count('ip_address');
        } catch (\Throwable $e) {
            $totalUniqueVisitors = 0;
            $todayUniqueVisitors = 0;
        }

        try {
            $totalActivities = \Spatie\Activitylog\Models\Activity::count();
            $todayActivities = \Spatie\Activitylog\Models\Activity::whereDate('created_at', today())->count();
        } catch (\Throwable $e) {
            $totalActivities = 0;
            $todayActivities = 0;
        }

        return [
            Stat::make('Total Unique Visitors', number_format($totalUniqueVisitors))
                ->description('Click to view IP, location & time spent')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('primary')
                ->extraAttributes([
                    'x-on:click' => "\$dispatch('open-modal', { id: 'unique-visitors-modal' })",
                    'wire:click' => 'openVisitorsModal',
                    'class' => 'cursor-pointer hover:ring-2 hover:ring-primary-500 hover:shadow-lg transition-all duration-200 select-none group',
                    'role' => 'button',
                    'tabindex' => '0',
                    'title' => 'Click to view IP, location and time on site for unique visitors',
                ]),
                
            Stat::make('Today\'s Unique Visitors', number_format($todayUniqueVisitors))
                ->description('Unique visitors today • Click to view')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('success')
                ->extraAttributes([
                    'x-on:click' => "\$dispatch('open-modal', { id: 'unique-visitors-modal' })",
                    'wire:click' => 'openVisitorsModal',
                    'class' => 'cursor-pointer hover:ring-2 hover:ring-success-500 hover:shadow-lg transition-all duration-200 select-none group',
                    'role' => 'button',
                    'tabindex' => '0',
                    'title' => 'Click to view unique visitors',
                ]),

            Stat::make('Total Activity Logs', number_format($totalActivities))
                ->description("{$todayActivities} events today")
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('danger'),
        ];
    }
}


