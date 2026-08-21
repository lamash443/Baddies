<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Visitor;

class SiteStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalUniqueVisitors = Visitor::distinct('ip_address')->count('ip_address');
        $todayUniqueVisitors = Visitor::whereDate('visit_date', today())->distinct('ip_address')->count('ip_address');
        $totalActivities = \Spatie\Activitylog\Models\Activity::count();
        $todayActivities = \Spatie\Activitylog\Models\Activity::whereDate('created_at', today())->count();

        return [
            Stat::make('Total Unique Visitors', number_format($totalUniqueVisitors))
                ->description('All time unique visitors (by IP)')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('Today\'s Unique Visitors', number_format($todayUniqueVisitors))
                ->description('Unique visitors today')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Total Activity Logs', number_format($totalActivities))
                ->description("{$todayActivities} events today")
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('danger'),
        ];
    }
}
