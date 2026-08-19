<?php

namespace App\Filament\Resources\MembershipPlans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembershipPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                TextColumn::make('slug')
                    ->searchable()
                    ->badge()
                    ->color('warning'),
                TextColumn::make('photo_limit')
                    ->numeric()
                    ->sortable()
                    ->label('Photos'),
                TextColumn::make('video_limit')
                    ->numeric()
                    ->sortable()
                    ->label('Videos'),
                TextColumn::make('pricing')
                    ->label('Pricing (KSh)')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return 'N/A';
                        $pricing = is_array($state) ? $state : json_decode($state, true);
                        if (!$pricing) return 'N/A';
                        return collect($pricing)->map(fn($v, $k) => "{$k}d: KSh{$v}")->implode(' | ');
                    })
                    ->wrap(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Last Updated'),
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
