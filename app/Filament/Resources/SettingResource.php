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
                Section::make('Email Verification Banner (Dashboard)')
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
                        TextInput::make('verification_toast_message')
                            ->label('Verification Sent Toast Message')
                            ->helperText('Text shown in the toast when the user requests a new verification link.')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
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

                Section::make('🟢 Online Status & Toast Notifications')
                    ->description('Control how and when the "User is Online" notification appears in the chat.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('online_toast_enabled')
                            ->label('Enable Online Toast Notification')
                            ->helperText('When ON, a toast pops up in the chat when a user comes online.')
                            ->columnSpanFull(),
                        Toggle::make('show_online_status_in_chat')
                            ->label('Show Online/Offline Status in Chat Header')
                            ->helperText('When OFF, the chat header will not show "Online" or "Last seen" text.')
                            ->columnSpanFull(),
                        TextInput::make('online_toast_message')
                            ->label('Toast Message Template')
                            ->helperText('Use {name} as a placeholder for the user\'s name.')
                            ->placeholder('💚 {name} is now online!')
                            ->columnSpanFull(),
                        \Filament\Forms\Components\Select::make('online_toast_position')
                            ->label('Toast Position')
                            ->options([
                                'top-left'      => 'Top Left',
                                'top-right'     => 'Top Right',
                                'top-center'    => 'Top Center',
                                'bottom-left'   => 'Bottom Left',
                                'bottom-right'  => 'Bottom Right (Default)',
                                'bottom-center' => 'Bottom Center',
                            ])
                            ->default('bottom-right'),
                        TextInput::make('online_toast_duration')
                            ->label('Toast Duration (ms)')
                            ->numeric()
                            ->helperText('How long the toast shows in milliseconds. e.g. 4000 = 4 seconds.')
                            ->default(4000),
                        \Filament\Forms\Components\Select::make('online_toast_sound')
                            ->label('Notification Sound')
                            ->options([
                                'none'  => 'No Sound',
                                'ping'  => 'Ping',
                                'chime' => 'Chime',
                                'pop'   => 'Pop',
                            ])
                            ->default('none'),
                        TextInput::make('online_threshold_minutes')
                            ->label('Online Threshold (minutes)')
                            ->numeric()
                            ->helperText('A user is considered "Online" if they were active within this many minutes.')
                            ->default(5),
                    ]),

                Section::make('Referral Program Settings')
                    ->description('Configure the referral bonus percentage awarded to users who invite friends.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('referral_commission_rate')
                            ->label('Referral Commission Rate (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.5)
                            ->suffix('%')
                            ->default(10.00)
                            ->helperText('Percentage of each wallet top-up credited to the referrer as a bonus. e.g. 10 = 10%.')
                            ->columnSpanFull(),
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
                IconColumn::make('online_toast_enabled')
                    ->label('Online Toast')
                    ->boolean(),
                IconColumn::make('show_online_status_in_chat')
                    ->label('Status in Chat')
                    ->boolean(),
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
