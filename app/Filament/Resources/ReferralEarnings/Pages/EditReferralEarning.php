<?php

namespace App\Filament\Resources\ReferralEarnings\Pages;

use App\Filament\Resources\ReferralEarnings\ReferralEarningResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditReferralEarning extends EditRecord
{
    protected static string $resource = ReferralEarningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
