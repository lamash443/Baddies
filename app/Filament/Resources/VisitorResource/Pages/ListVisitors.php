<?php

namespace App\Filament\Resources\VisitorResource\Pages;

use App\Filament\Resources\VisitorResource;
use App\Filament\Resources\VisitorResource\Widgets\VisitorOverviewWidget;
use App\Models\Visitor;
use Filament\Actions\Action;
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
                ->label('Purge Old Logs (>30 Days)')
                ->icon('heroicon-m-trash')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Purge Visitor Logs Older Than 30 Days')
                ->modalDescription('This will permanently delete all visitor session logs recorded more than 30 days ago to free up database storage. This action cannot be undone.')
                ->modalSubmitActionLabel('Purge Old Logs')
                ->action(function () {
                    $threshold = now()->subDays(30);
                    $deleted = Visitor::where('created_at', '<', $threshold)
                        ->orWhere('visit_date', '<', $threshold->toDateString())
                        ->delete();

                    Notification::make()
                        ->title('Logs Purged Successfully')
                        ->body("Deleted {$deleted} historical visitor session records.")
                        ->success()
                        ->send();
                }),
        ];
    }
}
