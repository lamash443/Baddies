<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Location;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
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
