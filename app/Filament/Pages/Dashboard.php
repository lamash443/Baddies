<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStatsWidget;
use App\Filament\Widgets\DepositsChartWidget;
use App\Filament\Widgets\RecentUsersWidget;
use App\Filament\Widgets\SiteStatsOverview;
use Filament\Widgets\AccountWidget;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            DashboardStatsWidget::class,
            SiteStatsOverview::class,
            DepositsChartWidget::class,
            RecentUsersWidget::class,
        ];
    }
}
