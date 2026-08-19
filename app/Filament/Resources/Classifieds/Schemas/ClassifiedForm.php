<?php

namespace App\Filament\Resources\Classifieds\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClassifiedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Select::make('category')
                    ->options(['personals' => 'Personals', 'jobs' => 'Jobs', 'massage' => 'Massage', 'events' => 'Events'])
                    ->required(),
                TextInput::make('city')
                    ->default(null),
                FileUpload::make('image_path')
                    ->disk('public')
                    ->directory('classifieds')
                    ->image(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('contact_name')
                    ->default(null),
                Select::make('payment_status')
                    ->options(['pending' => 'Pending', 'paid' => 'Paid'])
                    ->default('pending')
                    ->required(),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'])
                    ->default('approved')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(1000.0),
            ]);
    }
}
