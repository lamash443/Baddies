<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepositForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('User'),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('Ksh')
                    ->label('Amount'),
                Select::make('status')
                    ->required()
                    ->options([
                        'pending'   => 'Pending',
                        'completed' => 'Completed',
                        'failed'    => 'Failed',
                    ])
                    ->default('pending'),
                Select::make('payment_method')
                    ->required()
                    ->options([
                        'mpesa'  => 'M-Pesa',
                        'card'   => 'Card',
                        'manual' => 'Manual',
                    ])
                    ->default('mpesa')
                    ->label('Payment Method'),
                TextInput::make('reference')
                    ->label('Reference')
                    ->nullable(),
                TextInput::make('checkout_request_id')
                    ->label('Checkout Request ID')
                    ->nullable(),
                TextInput::make('payhero_reference')
                    ->label('PayHero Reference')
                    ->nullable(),
            ]);
    }
}
