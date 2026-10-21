<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Location;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->syncLocationFromRecord();
    }

    protected function syncLocationFromRecord(): void
    {
        $county = $this->record->county;
        if ($county) {
            Location::firstOrCreate(
                ['name' => $county],
                ['type' => 'county', 'is_active' => true]
            );
        }

        $location = $this->record->location;
        if ($location) {
            Location::firstOrCreate(
                ['name' => $location],
                ['type' => 'area', 'is_active' => true]
            );
        }
    }
}
