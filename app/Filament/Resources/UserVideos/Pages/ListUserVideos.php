<?php

namespace App\Filament\Resources\UserVideos\Pages;

use App\Filament\Resources\UserVideos\UserVideoResource;
use Filament\Resources\Pages\ListRecords;

class ListUserVideos extends ListRecords
{
    protected static string $resource = UserVideoResource::class;
}
