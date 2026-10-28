<?php

namespace App\Filament\Resources\SupportTickets\Pages;

use App\Filament\Resources\SupportTickets\SupportTicketResource;
use App\Mail\SupportTicketReply;
use App\Models\EmailLog;
use App\Support\MailHelper;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ViewSupportTicket extends ViewRecord
{
    protected static string $resource = SupportTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reply')
                ->label('Reply to User')
                ->icon('heroicon-o-envelope')
                ->color('primary')
                ->form([
                    Textarea::make('reply_message')
                        ->label('Your Reply')
                        ->required()
                        ->rows(6)
                        ->placeholder('Type your reply here...'),
                ])
                ->action(function (array $data) {
                    MailHelper::applySmtpSettings();

                    try {
                        Mail::to($this->record->email, $this->record->name)
                            ->send(new SupportTicketReply($this->record, $data['reply_message']));

                        $this->record->update(['status' => 'resolved']);

                        EmailLog::create([
                            'user_id'         => $this->record->user_id,
                            'recipient_email' => $this->record->email,
                            'recipient_name'  => $this->record->name,
                            'subject'         => 'Re: ' . $this->record->subject,
                            'type'            => 'support_reply',
                            'status'          => 'sent',
                        ]);

                        Notification::make()
                            ->title('Reply sent successfully')
                            ->body('Email delivered to ' . $this->record->email . ' and ticket marked as resolved.')
                            ->success()
                            ->send();

                    } catch (\Throwable $e) {
                        Log::error('[SupportTicketReply] FAILED for ticket #' . $this->record->id . ': ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());

                        EmailLog::create([
                            'user_id'         => $this->record->user_id,
                            'recipient_email' => $this->record->email,
                            'recipient_name'  => $this->record->name,
                            'subject'         => 'Re: ' . $this->record->subject,
                            'type'            => 'support_reply',
                            'status'          => 'failed',
                            'error_message'   => $e->getMessage() . ' (' . basename($e->getFile()) . ':' . $e->getLine() . ')',
                        ]);

                        Notification::make()
                            ->title('Failed to send reply email')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            EditAction::make(),
        ];
    }
}
