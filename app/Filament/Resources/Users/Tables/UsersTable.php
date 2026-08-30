<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                TextColumn::make('county')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('wallet_balance')
                    ->label('Balance (Ksh)')
                    ->numeric(2)
                    ->prefix('Ksh ')
                    ->sortable(),
                TextColumn::make('gender')
                    ->sortable(),
                TextColumn::make('age')
                    ->sortable(),
                TextColumn::make('profile_views')
                    ->label('Profile Views')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('phone_calls')
                    ->label('Phone Calls')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                TextColumn::make('subscription_plan')
                    ->label('Plan')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'prime_vip' => 'success',
                        'prime'     => 'warning',
                        'vip'       => 'info',
                        'regular'   => 'gray',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'prime_vip' => 'Prime VIP',
                        'prime'     => 'Prime',
                        'vip'       => 'VIP',
                        'regular'   => 'Regular',
                        default     => 'No Plan',
                    })
                    ->sortable(),
                TextColumn::make('subscription_expires_at')
                    ->label('Profile Plan Expires')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('chat_plan')
                    ->label('Chat Plan')
                    ->badge()
                    ->color('secondary')
                    ->sortable(),
                TextColumn::make('chat_expires_at')
                    ->label('Chat Plan Expires')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_seen_at')
                    ->label('Online Status')
                    ->badge()
                    ->color(fn ($record) => $record->isOnline() ? 'success' : 'gray')
                    ->formatStateUsing(fn ($record) => $record->isOnline() ? 'Online' : ($record->last_seen_at ? 'Seen ' . $record->last_seen_at->diffForHumans() : 'Offline'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('photos_count')
                    ->label('Photos')
                    ->counts('photos')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('videos_count')
                    ->label('Videos')
                    ->counts('videos')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                 IconColumn::make('is_admin')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_blocked')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deletion_requested_at')
                    ->label('Pending Deletion')
                    ->badge()
                    ->color(fn ($state) => $state ? 'danger' : 'gray')
                    ->formatStateUsing(fn ($state) => $state ? $state->format('d M Y, H:i') : '—')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('approve_deletion')
                    ->label('Approve Deletion')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Account Deletion')
                    ->modalDescription('Are you sure you want to permanently delete this user account and all associated data?')
                    ->visible(fn (\App\Models\User $record): bool => !is_null($record->deletion_requested_at))
                    ->action(function (\App\Models\User $record) {
                        $record->delete();
                    }),
                Action::make('restore_account')
                    ->label('Restore Account')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Restore Account')
                    ->modalDescription('Are you sure you want to reject the deletion request and restore this account?')
                    ->visible(fn (\App\Models\User $record): bool => !is_null($record->deletion_requested_at))
                    ->action(function (\App\Models\User $record) {
                        $record->update(['deletion_requested_at' => null]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}