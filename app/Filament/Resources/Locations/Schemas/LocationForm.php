<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Select::make('type')
                    ->required()
                    ->options([
                        'road' => 'Road',
                        'area' => 'Area',
                        'county' => 'County',
                    ]),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }
}
