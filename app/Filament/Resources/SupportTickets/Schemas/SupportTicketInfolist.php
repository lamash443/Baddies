<?php

namespace App\Filament\Resources\SupportTickets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SupportTicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ticket Details')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('user.name')
                                ->label('Associated User')
                                ->placeholder('Guest Ticket'),
                            TextEntry::make('name')
                                ->label('Sender Name'),
                            TextEntry::make('email')
                                ->label('Sender Email'),
                            
                            TextEntry::make('status')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'pending'     => 'warning',
                                    'in_progress' => 'info',
                                    'resolved'    => 'success',
                                    'closed'      => 'gray',
                                    default       => 'gray',
                                }),
                            TextEntry::make('created_at')
                                ->label('Submitted At')
                                ->dateTime(),
                            TextEntry::make('updated_at')
                                ->label('Last Updated')
                                ->dateTime(),
                        ]),
                    ]),
                
                Section::make('Message')
                    ->schema([
                        TextEntry::make('subject')
                            ->weight('bold'),
                        TextEntry::make('message')
                            ->hiddenLabel()
                            ->columnSpanFull()
                            ->extraAttributes([
                                'style' => 'white-space: pre-line; padding: 1rem; background: rgba(0,0,0,0.03); border-radius: 8px; margin-top: 0.5rem;',
                            ]),
                    ]),
            ]);
    }
}
