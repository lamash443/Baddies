<?php

namespace App\Filament\Resources\Classifieds\Pages;

use App\Filament\Resources\Classifieds\ClassifiedResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClassified extends CreateRecord
{
    protected static string $resource = ClassifiedResource::class;
}
