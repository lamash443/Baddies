<?php

namespace App\Filament\Resources\ReferralEarnings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ReferralEarningsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('referrer.name')
                    ->label('Referrer')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('referee.name')
                    ->label('Referee (Depositor)')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('deposit_amount')
                    ->label('Deposit')
                    ->numeric(2)
                    ->prefix('Ksh ')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('commission_rate')
                    ->label('Rate (%)')
                    ->numeric(0)
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('bonus_amount')
                    ->label('Bonus')
                    ->numeric(2)
                    ->prefix('Ksh ')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'awarded' => 'warning',
                        'redeemed' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Awarded At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
