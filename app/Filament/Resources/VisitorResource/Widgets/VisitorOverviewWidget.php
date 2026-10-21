<?php

namespace App\Filament\Resources\VisitorResource\Widgets;

use App\Models\Visitor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Schema;

class VisitorOverviewWidget extends BaseWidget
{
    protected function getPollingInterval(): ?string
    {
        return '30s';
    }

    protected function getStats(): array
    {
        try {
            $totalUnique = Visitor::distinct('ip_address')->count('ip_address');
            $todayUnique = Visitor::whereDate('visit_date', today())->distinct('ip_address')->count('ip_address');
            $totalPageviews = Visitor::sum('visits_count') ?: 0;
            
            $hasTime = Schema::hasColumn('visitors', 'total_time_seconds');
            $totalSeconds = $hasTime ? (int) Visitor::sum('total_time_seconds') : 0;
            
            // Format total hours/minutes
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $formattedTime = $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";

            // Online now (within last 15 minutes)
            $onlineNow = Visitor::where('last_visit_at', '>=', now()->subMinutes(15))->count();

            // Top country
            $hasCountry = Schema::hasColumn('visitors', 'country');
            $topCountryName = 'Unknown';
            $topCountryCount = 0;
            if ($hasCountry) {
                $top = Visitor::whereNotNull('country')
                    ->where('country', '!=', '')
                    ->where('country', '!=', 'Unknown')
                    ->selectRaw('country, COUNT(*) as count')
                    ->groupBy('country')
                    ->orderByDesc('count')
                    ->first();
                if ($top) {
                    $topCountryName = $top->country;
                    $topCountryCount = $top->count;
                }
            }

            return [
                Stat::make('Total Unique Visitors', number_format($totalUnique))
                    ->description('Unique IP addresses logged')
                    ->descriptionIcon('heroicon-m-globe-alt')
                    ->color('primary')
                    ->chart([7, 12, 18, 25, 30, 42, $totalUnique > 0 ? min(50, $totalUnique) : 10]),

                Stat::make('Active Today', number_format($todayUnique))
                    ->description('Unique visitors today')
                    ->descriptionIcon('heroicon-m-user-group')
                    ->color('success')
                    ->chart([3, 5, 8, 12, 10, 15, $todayUnique > 0 ? min(30, $todayUnique) : 5]),

                Stat::make('Online Right Now', number_format($onlineNow))
                    ->description('Active within last 15m')
                    ->descriptionIcon('heroicon-m-signal')
                    ->color($onlineNow > 0 ? 'success' : 'gray'),

                Stat::make('Total Pageviews', number_format($totalPageviews))
                    ->description('Total page requests tracked')
                    ->descriptionIcon('heroicon-m-eye')
                    ->color('info'),

                Stat::make('Total Time Engaged', $formattedTime)
                    ->description('Cumulative time on site')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),

                Stat::make('Top Visitor Country', $topCountryName)
                    ->description($topCountryCount > 0 ? "{$topCountryCount} sessions logged" : 'Awaiting data')
                    ->descriptionIcon('heroicon-m-map-pin')
                    ->color('primary'),
            ];
        } catch (\Throwable $e) {
            return [
                Stat::make('Unique Visitors', '—')
                    ->description('Analytics loading...')
                    ->color('gray'),
            ];
        }
    }
}
