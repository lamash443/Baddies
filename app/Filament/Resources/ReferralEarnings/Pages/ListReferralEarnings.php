<?php

namespace App\Filament\Resources\ReferralEarnings\Pages;

use App\Filament\Resources\ReferralEarnings\ReferralEarningResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReferralEarnings extends ListRecords
{
    protected static string $resource = ReferralEarningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
