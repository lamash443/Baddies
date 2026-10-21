<?php

namespace App\Filament\Resources\VisitorResource\Pages;

use App\Filament\Resources\VisitorResource;
use App\Filament\Resources\VisitorResource\Widgets\VisitorOverviewWidget;
use App\Models\Visitor;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListVisitors extends ListRecords
{
    protected static string $resource = VisitorResource::class;

    protected static ?string $title = 'Visitors Tracking';

    public function getSubheading(): ?string
    {
        return 'Real-time telemetry, geographic breakdown, device analytics, and session engagement.';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            VisitorOverviewWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('purge_old_logs')
                ->label('Purge Old Logs')
                ->icon('heroicon-m-trash')
                ->color('danger')
                ->modalHeading('Purge Historical Visitor Logs')
                ->modalDescription('Select a timeframe to permanently remove older visitor telemetry records and free up database storage. This action cannot be undone.')
                ->modalSubmitActionLabel('Purge Selected Logs')
                ->form([
                    Select::make('timeframe')
                        ->label('Purge Logs Older Than')
                        ->options([
                            '7'   => 'Older than 1 week (7 days)',
                            '14'  => 'Older than 2 weeks (14 days)',
                            '30'  => 'Older than 1 month (30 days)',
                            '60'  => 'Older than 2 months (60 days)',
                            '90'  => 'Older than 3 months (90 days)',
                        ])
                        ->default('14')
                        ->required()
                        ->helperText('All visitor records older than this timeframe will be permanently deleted.'),
                ])
                ->action(function (array $data) {
                    $days = (int) ($data['timeframe'] ?? 14);
                    $threshold = now()->subDays($days);
                    $deleted = Visitor::where(function ($query) use ($threshold) {
                        $query->where('created_at', '<', $threshold)
                              ->orWhere('visit_date', '<', $threshold->toDateString());
                    })->delete();

                    Notification::make()
                        ->title('Visitor Logs Purged')
                        ->body("Deleted {$deleted} historical visitor records older than {$days} days.")
                        ->success()
                        ->send();
                }),
        ];
    }
}
