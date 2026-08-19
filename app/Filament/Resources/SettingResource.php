<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Dashboard Banners';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unlock Exclusive Account Banner (Verification)')
                    ->columns(2)
                    ->schema([
                        Toggle::make('unlock_banner_enabled')
                            ->label('Banner Enabled')
                            ->columnSpanFull(),
                        TextInput::make('unlock_banner_title')
                            ->label('Banner Title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('unlock_banner_button_text')
                            ->label('Button Text')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('unlock_banner_description')
                            ->label('Banner Description')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),

                Section::make('Complete Your Profile Banner')
                    ->columns(2)
                    ->schema([
                        Toggle::make('profile_banner_enabled')
                            ->label('Banner Enabled')
                            ->columnSpanFull(),
                        TextInput::make('profile_banner_title')
                            ->label('Banner Title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('profile_banner_button_text')
                            ->label('Button Text')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('profile_banner_description')
                            ->label('Banner Description')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('unlock_banner_enabled')
                    ->label('Unlock Banner Active')
                    ->boolean(),
                TextColumn::make('unlock_banner_title')
                    ->label('Unlock Banner Title'),
                IconColumn::make('profile_banner_enabled')
                    ->label('Profile Banner Active')
                    ->boolean(),
                TextColumn::make('profile_banner_title')
                    ->label('Profile Banner Title'),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
