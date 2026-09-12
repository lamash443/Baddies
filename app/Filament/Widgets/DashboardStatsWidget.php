<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        $totalUsers = User::count();
        $verifiedUsers = User::where('is_verified', true)->count();
        $newRegistrations = User::where('created_at', '>=', now()->startOfDay())->count();
        $totalDeposits = \App\Models\Deposit::where('status', 'completed')->sum('amount');
        
        // Count active sessions in the file driver (last 15 minutes) as a proxy for online users
        $onlineUsers = 0;
        $sessionFiles = \Illuminate\Support\Facades\File::files(storage_path('framework/sessions'));
        $fifteenMinutesAgo = now()->subMinutes(15)->timestamp;
        
        foreach ($sessionFiles as $file) {
            if ($file->getMTime() >= $fifteenMinutesAgo && $file->getExtension() !== 'gitignore') {
                $onlineUsers++;
            }
        }

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Verified Users', $verifiedUsers)
                ->description('Users with verified profiles')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Total Deposits', 'KSh ' . number_format($totalDeposits, 2))
                ->description('Total completed deposits')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('New Registrations', $newRegistrations)
                ->description('Users joined today')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('warning'),

            Stat::make('Online Users', $onlineUsers)
                ->description('Active in the last 15 mins')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('info'),

            Stat::make('Emails Sent', number_format(\App\Models\EmailLog::sent()->count()))
                ->description(\App\Models\EmailLog::sent()->today()->count() . ' sent today')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('success'),
        ];

    }
}
