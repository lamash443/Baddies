<?php

namespace App\Filament\Resources\Activities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('When')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at?->format('d M Y H:i:s T'))
                    ->color('primary'),

                TextColumn::make('log_name')
                    ->label('Log')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'default' => 'primary',
                        'auth'    => 'info',
                        'admin'   => 'warning',
                        default   => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('event')
                    ->label('Action')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'info',
                        'deleted' => 'danger',
                        'login'   => 'warning',
                        default   => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->description),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->badge()
                    ->color('secondary')
                    ->icon('heroicon-m-user')
                    ->placeholder('System'),

                TextColumn::make('subject_type')
                    ->label('Subject')
                    ->sortable()
                    ->formatStateUsing(fn (?string $state) => $state ? class_basename($state) : '—')
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                        'login'   => 'Login',
                    ]),

                SelectFilter::make('log_name')
                    ->label('Log Channel')
                    ->options([
                        'default' => 'Default',
                        'auth'    => 'Auth',
                        'admin'   => 'Admin',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No activity logs yet')
            ->emptyStateDescription('Activity logs will appear here as users interact with the platform.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }
}
