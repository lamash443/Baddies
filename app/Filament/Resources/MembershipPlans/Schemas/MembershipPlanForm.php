<?php

namespace App\Filament\Resources\MembershipPlans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MembershipPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('photo_limit')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('video_limit')
                    ->required()
                    ->numeric()
                    ->default(0),
                \Filament\Forms\Components\TagsInput::make('features')
                    ->placeholder('Add a feature and press Enter')
                    ->columnSpanFull(),
                \Filament\Forms\Components\KeyValue::make('pricing')
                    ->keyLabel('Days (e.g. 3, 7, 15, 30)')
                    ->valueLabel('Price (KSh)')
                    ->columnSpanFull(),
            ]);
    }
}
