<?php

namespace App\Filament\Resources\UserPhotos\Pages;

use App\Filament\Resources\UserPhotos\UserPhotoResource;
use App\Models\User;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUserPhotos extends ListRecords
{
    protected static string $resource = UserPhotoResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Photos'),

            'prime_vip' => Tab::make('Prime VIP')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user', fn ($q) => $q->where('subscription_plan', 'prime_vip')))
                ->badge(
                    \App\Models\UserPhoto::whereHas('user', fn ($q) => $q->where('subscription_plan', 'prime_vip'))->count()
                )
                ->badgeColor('danger'),

            'vip' => Tab::make('VIP')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user', fn ($q) => $q->where('subscription_plan', 'vip')))
                ->badge(
                    \App\Models\UserPhoto::whereHas('user', fn ($q) => $q->where('subscription_plan', 'vip'))->count()
                )
                ->badgeColor('warning'),

            'prime' => Tab::make('Prime')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user', fn ($q) => $q->where('subscription_plan', 'prime')))
                ->badge(
                    \App\Models\UserPhoto::whereHas('user', fn ($q) => $q->where('subscription_plan', 'prime'))->count()
                )
                ->badgeColor('info'),

            'regular' => Tab::make('Regular')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user', fn ($q) => $q->where('subscription_plan', 'regular')))
                ->badge(
                    \App\Models\UserPhoto::whereHas('user', fn ($q) => $q->where('subscription_plan', 'regular'))->count()
                )
                ->badgeColor('gray'),
        ];
    }
}
