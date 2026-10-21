<?php

namespace App\Filament\Resources\BlockedIpResource\Pages;

use App\Filament\Resources\BlockedIpResource;
use Filament\Resources\Pages\ListRecords;

class ListBlockedIps extends ListRecords
{
    protected static string $resource = BlockedIpResource::class;
}
