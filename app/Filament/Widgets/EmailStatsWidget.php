<?php

namespace App\Filament\Widgets;

use App\Models\EmailLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmailStatsWidget extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $totalSent     = EmailLog::sent()->count();
        $totalFailed   = EmailLog::failed()->count();
        $sentToday     = EmailLog::sent()->today()->count();
        $welcomeSent   = EmailLog::sent()->ofType('welcome')->count();
        $broadcastSent = EmailLog::sent()->ofType('broadcast')->count();

        // Trend: compare today vs yesterday for total sent
        $sentYesterday = EmailLog::sent()
            ->whereDate('created_at', today()->subDay())
            ->count();

        $trend = $sentToday >= $sentYesterday ? 'increase' : 'decrease';
        $trendIcon = $trend === 'increase'
            ? 'heroicon-m-arrow-trending-up'
            : 'heroicon-m-arrow-trending-down';

        return [
            Stat::make('Total Emails Sent', number_format($totalSent))
                ->description('All time successful sends')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('success'),

            Stat::make('Sent Today', $sentToday)
                ->description($sentYesterday . ' sent yesterday')
                ->descriptionIcon($trendIcon)
                ->color($trend === 'increase' ? 'success' : 'warning'),

            Stat::make('Welcome Emails', number_format($welcomeSent))
                ->description('Sent on registration')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('info'),

            Stat::make('Broadcast Emails', number_format($broadcastSent))
                ->description('Sent via admin panel')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning'),

            Stat::make('Failed Sends', $totalFailed)
                ->description($totalFailed > 0 ? 'Check Email Logs for errors' : 'All deliveries succeeded')
                ->descriptionIcon($totalFailed > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($totalFailed > 0 ? 'danger' : 'success'),
        ];
    }
}
