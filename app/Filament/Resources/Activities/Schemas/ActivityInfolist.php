<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Schemas\Schema;

class ActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('log_name')->badge(),
                        TextEntry::make('event'),
                        TextEntry::make('description')->columnSpanFull(),
                        TextEntry::make('causer.name')->label('Performed By'),
                        TextEntry::make('causer.email')->label('User Email'),
                        TextEntry::make('subject_type')->label('Model'),
                        TextEntry::make('subject_id')->label('Record ID'),
                        TextEntry::make('created_at')->dateTime()->label('When'),
                    ]),
                Section::make('Changed Properties')
                    ->schema([
                        KeyValueEntry::make('properties.attributes')
                            ->label('New Values'),
                        KeyValueEntry::make('properties.old')
                            ->label('Old Values'),
                    ]),
            ]);
    }
}
