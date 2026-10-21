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
        $county = trim($this->record->county ?? '');
        if ($county !== '') {
            $existingCounty = Location::whereRaw('LOWER(name) = ?', [strtolower($county)])->first();
            if (!$existingCounty) {
                Location::create([
                    'name' => $county,
                    'type' => 'county',
                    'is_active' => true,
                ]);
            }
        }

        $location = trim($this->record->location ?? '');
        if ($location !== '') {
            $existingLocation = Location::whereRaw('LOWER(name) = ?', [strtolower($location)])->first();
            if (!$existingLocation) {
                Location::create([
                    'name' => $location,
                    'type' => 'area',
                    'is_active' => true,
                ]);
            }
        }
    }
}
