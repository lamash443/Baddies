<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentUsersWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Recently Registered Users';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->searchable()
                    ->color('gray'),

                TextColumn::make('phone_number')
                    ->label('Phone')
                    ->placeholder('—'),

                TextColumn::make('gender')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'female' => 'success',
                        'male'   => 'info',
                        default  => 'gray',
                    }),

                TextColumn::make('subscription_plan')
                    ->label('Plan')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'prime_vip' => 'success',
                        'prime'     => 'warning',
                        'vip'       => 'info',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'prime_vip' => 'Prime VIP',
                        'prime'     => 'Prime',
                        'vip'       => 'VIP',
                        'regular'   => 'Regular',
                        default     => 'Free',
                    }),

                IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                TextColumn::make('created_at')
                    ->label('Joined')
                    ->since()
                    ->color('gray'),
            ])
            ->paginated(false);
    }
}
