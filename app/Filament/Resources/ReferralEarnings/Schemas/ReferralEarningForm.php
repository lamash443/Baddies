<?php

namespace App\Filament\Resources\ReferralEarnings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReferralEarningForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Referral Details')
                    ->columns(2)
                    ->schema([
                        Select::make('referrer_id')
                            ->label('Referrer')
                            ->relationship('referrer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('referee_id')
                            ->label('Referee (Depositor)')
                            ->relationship('referee', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                Section::make('Earning Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('deposit_amount')
                            ->label('Deposit Amount (Ksh)')
                            ->numeric()
                            ->prefix('Ksh')
                            ->required(),
                        TextInput::make('commission_rate')
                            ->label('Commission Rate (%)')
                            ->numeric()
                            ->suffix('%')
                            ->required(),
                        TextInput::make('bonus_amount')
                            ->label('Bonus Amount (Ksh)')
                            ->numeric()
                            ->prefix('Ksh')
                            ->required(),
                        Select::make('status')
                            ->options([
                                'awarded'  => 'Awarded',
                                'redeemed' => 'Redeemed',
                            ])
                            ->required(),
                    ]),
                TextInput::make('deposit_id')
                    ->label('Source Deposit ID')
                    ->numeric()
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
