<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                \Filament\Forms\Components\RichEditor::make('content')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->label('Contact Phone Number')
                    ->placeholder('+254700000000')
                    ->helperText('Displayed on the Contact page. Leave blank if not applicable.')
                    ->nullable()
                    ->tel()
                    ->columnSpanFull(),
            ]);
    }
}
