<?php

namespace App\Filament\Resources\SupportTickets\Pages;

use App\Filament\Resources\SupportTickets\SupportTicketResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSupportTicket extends ViewRecord
{
    protected static string $resource = SupportTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('reply')
                ->label('Reply to User')
                ->icon('heroicon-o-envelope')
                ->color('primary')
                ->form([
                    \Filament\Forms\Components\Textarea::make('reply_message')
                        ->label('Your Reply')
                        ->required()
                        ->rows(5)
                ])
                ->action(function (array $data) {
                    $port = (int) \App\Models\SiteSetting::get('mail_port', config('mail.mailers.smtp.port', 465));
                    $rawScheme = \App\Models\SiteSetting::get('mail_encryption', config('mail.mailers.smtp.scheme', 'smtps'));
                    $scheme = match(strtolower(trim((string) $rawScheme))) {
                        'ssl', 'smtps' => 'smtps',
                        'tls', 'starttls', 'smtp' => 'smtp',
                        default => ($port === 465 ? 'smtps' : 'smtp'),
                    };

                    config([
                        'mail.default'               => \App\Models\SiteSetting::get('mail_mailer', config('mail.default', 'smtp')),
                        'mail.mailers.smtp.host'     => \App\Models\SiteSetting::get('mail_host', config('mail.mailers.smtp.host')),
                        'mail.mailers.smtp.port'     => $port,
                        'mail.mailers.smtp.scheme'   => $scheme,
                        'mail.mailers.smtp.username' => \App\Models\SiteSetting::get('mail_username', config('mail.mailers.smtp.username')),
                        'mail.mailers.smtp.password' => \App\Models\SiteSetting::get('mail_password', config('mail.mailers.smtp.password')),
                        'mail.from.address'          => \App\Models\SiteSetting::get('mail_from_address', config('mail.from.address')),
                        'mail.from.name'             => \App\Models\SiteSetting::get('mail_from_name', config('mail.from.name', 'Baddies Club')),
                    ]);
                    app('mail.manager')->purge('smtp');

                    \Illuminate\Support\Facades\Mail::to($this->record->email)
                        ->send(new \App\Mail\SupportTicketReply($this->record, $data['reply_message']));
                    
                    $this->record->update(['status' => 'resolved']);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Reply sent successfully')
                        ->success()
                        ->send();
                }),
            EditAction::make(),
        ];
    }
}
