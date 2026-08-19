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
