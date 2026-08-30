<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('Account Status')
                    ->columns(3)
                    ->schema([
                        Toggle::make('is_admin')
                            ->label('Admin'),
                        Toggle::make('is_blocked')
                            ->label('Blocked'),
                        Toggle::make('is_verified')
                            ->label('Verified')
                            ->helperText('Approve verification photo — unlocks plan selection.'),
                        DateTimePicker::make('deletion_requested_at')
                            ->label('Deletion Requested At')
                            ->disabled()
                            ->placeholder('No request')
                            ->nullable(),
                        TextInput::make('wallet_balance')
                            ->label('Wallet Balance (Ksh)')
                            ->numeric()
                            ->default(0.00)
                            ->prefix('Ksh')
                            ->columnSpanFull(),
                    ]),

                Section::make('Statistics')
                    ->columns(2)
                    ->schema([
                        TextInput::make('profile_views')
                            ->label('Profile Views')
                            ->numeric()
                            ->default(0),
                        TextInput::make('phone_calls')
                            ->label('Phone Calls')
                            ->numeric()
                            ->default(0),
                    ]),

                Section::make('Profile Details')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('profile_photo')
                            ->image()
                            ->directory('profile_photos')
                            ->columnSpanFull(),
                        TextInput::make('phone_number')
                            ->tel(),
                        Select::make('gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ]),
                        Select::make('sexual_orientation')
                            ->options([
                                'Straight' => 'Straight',
                                'Gay' => 'Gay',
                                'Lesbian' => 'Lesbian',
                                'Bisexual' => 'Bisexual',
                                'Transgender' => 'Transgender',
                            ]),
                        TextInput::make('age')
                            ->numeric()
                            ->minValue(18),
                        TextInput::make('nationality'),
                        Select::make('county')
                            ->options([
                                'Mombasa'=>'Mombasa','Nakuru'=>'Nakuru','Kiambu'=>'Kiambu','Kisumu'=>'Kisumu','Machakos'=>'Machakos','Kajiado'=>'Kajiado','Uasin Gishu'=>'Uasin Gishu','Kilifi'=>'Kilifi','Meru'=>'Meru','Nyeri'=>'Nyeri','Embu'=>'Embu','Kakamega'=>'Kakamega','Bungoma'=>'Bungoma','Bomet'=>'Bomet','Kisii'=>'Kisii','Migori'=>'Migori','Homa Bay'=>'Homa Bay','Siaya'=>'Siaya','Vihiga'=>'Vihiga','Trans Nzoia'=>'Trans Nzoia','Nandi'=>'Nandi','Elgeyo Marakwet'=>'Elgeyo Marakwet','Baringo'=>'Baringo','Laikipia'=>'Laikipia','Nyandarua'=>'Nyandarua','Murang\'a'=>'Murang\'a','Kirinyaga'=>'Kirinyaga','Tharaka Nithi'=>'Tharaka Nithi','Isiolo'=>'Isiolo','Garissa'=>'Garissa','Wajir'=>'Wajir','Mandera'=>'Mandera','Marsabit'=>'Marsabit','Samburu'=>'Samburu','Turkana'=>'Turkana','West Pokot'=>'West Pokot','Lamu'=>'Lamu','Taita Taveta'=>'Taita Taveta','Kwale'=>'Kwale','Tana River'=>'Tana River','Narok'=>'Narok','Kericho'=>'Kericho','Nyamira'=>'Nyamira','Rachuonyo'=>'Rachuonyo',
                            ])
                            ->searchable(),
                        TextInput::make('city_town'),
                        Select::make('location')
                            ->options([
                                'Major Roads' => [
                                    'James Gichuru Road'=>'James Gichuru Road','Southern Bypass'=>'Southern Bypass','Gitanga Road'=>'Gitanga Road','Naivasha Road'=>'Naivasha Road','Northern Bypass'=>'Northern Bypass','Eastern Bypass'=>'Eastern Bypass','Manyanja Rd'=>'Manyanja Rd','Waiyaki Way'=>'Waiyaki Way','Kiambu Road'=>'Kiambu Road','Langata Road'=>'Langata Road','Outering Road'=>'Outering Road','Kangundo Road'=>'Kangundo Road','Ngong Road'=>'Ngong Road','Kamiti Road'=>'Kamiti Road','Jogoo Road'=>'Jogoo Road','Mombasa Road'=>'Mombasa Road','Thika Road'=>'Thika Road',
                                ],
                                'Nairobi Areas' => [
                                    'Allsops'=>'Allsops','Banana'=>'Banana','Buruburu'=>'Buruburu','Chokaa'=>'Chokaa','Dagoretti'=>'Dagoretti','Dandora'=>'Dandora','Donholm'=>'Donholm','Eastlands'=>'Eastlands','Eastleigh'=>'Eastleigh','Embakasi'=>'Embakasi','Garden City'=>'Garden City','Githurai 44'=>'Githurai 44','Githurai 45'=>'Githurai 45','Homeland'=>'Homeland','Hurlingham'=>'Hurlingham','Huruma'=>'Huruma','Imara Daima'=>'Imara Daima','Jamhuri'=>'Jamhuri','Joska'=>'Joska','Juja'=>'Juja','Kabete'=>'Kabete','Kahawa Sukari'=>'Kahawa Sukari','Kahawa Wendani'=>'Kahawa Wendani','Kahawa West'=>'Kahawa West','Kamulu'=>'Kamulu','Kangemi'=>'Kangemi','Karen'=>'Karen','Kariobangi'=>'Kariobangi','Kasarani'=>'Kasarani','Kawangware'=>'Kawangware','Kayole'=>'Kayole','Kenyatta Road'=>'Kenyatta Road','Kibera'=>'Kibera','Kikuyu'=>'Kikuyu','Kileleshwa'=>'Kileleshwa','Kilimani'=>'Kilimani','Kitengela'=>'Kitengela','Kitisuru'=>'Kitisuru','Komarock'=>'Komarock','Langata'=>'Langata','Lavington'=>'Lavington','Loresho'=>'Loresho','Madaraka'=>'Madaraka','Makadara'=>'Makadara','Malaa'=>'Malaa','Mathare'=>'Mathare','Milimani'=>'Milimani','Mlolongo'=>'Mlolongo','Muthaiga'=>'Muthaiga','Muthangari'=>'Muthangari','Muthurwa'=>'Muthurwa','Mwiki'=>'Mwiki','Nairobi Town'=>'Nairobi Town','Nairobi West'=>'Nairobi West','Ndenderu'=>'Ndenderu','Ngara'=>'Ngara','Ngong'=>'Ngong','Ngumba'=>'Ngumba','Njiru'=>'Njiru','Pangani'=>'Pangani','Parklands'=>'Parklands','Roasters'=>'Roasters','Ongata Rongai'=>'Ongata Rongai','Roysambu'=>'Roysambu','Ruai'=>'Ruai','Ruaka'=>'Ruaka','Ruaraka'=>'Ruaraka','Ruiru'=>'Ruiru','Runda'=>'Runda','Saika'=>'Saika','South B'=>'South B','South C'=>'South C','Syokimau'=>'Syokimau','Thogoto'=>'Thogoto','Thome'=>'Thome','Umoja'=>'Umoja','Upper Hill'=>'Upper Hill','Utawala'=>'Utawala','Uthiru'=>'Uthiru','Westlands'=>'Westlands',
                                ],
                            ])
                            ->searchable(),
                        TextInput::make('area'),
                        TextInput::make('nearby_places'),
                        Select::make('services')
                            ->multiple()
                            ->options([
                                'Incall Sex'          => 'Incall Sex',
                                'Outcall Sex'         => 'Outcall Sex',
                                'Erotic Massage'      => 'Erotic Massage',
                                'Erotic Dancing'      => 'Erotic Dancing',
                                'Video Calls'         => 'Video Calls',
                                'VIP Companionship'   => 'VIP Companionship',
                                'BDSM'                => 'BDSM',
                                'Dinner Date'         => 'Dinner Date',
                                'Travel Companion'    => 'Travel Companion',
                                'Lesbian Show'        => 'Lesbian Show',
                                'Rimming'             => 'Rimming',
                                'Raw BJ'              => 'Raw BJ',
                                'BJ'                  => 'BJ',
                                'Girlfriend Experience' => 'Girlfriend Experience',
                                'COB – Cum On Body'   => 'COB – Cum On Body',
                                'CIM – Cum In Mouth'  => 'CIM – Cum In Mouth',
                                '3 Some'              => '3 Some',
                                'Anal'                => 'Anal',
                                'Massage'             => 'Massage',
                            ])
                            ->searchable()
                            ->columnSpanFull(),
                        Textarea::make('other_services')
                            ->columnSpanFull(),
                        TextInput::make('incalls_rate')
                            ->numeric()
                            ->prefix('Ksh'),
                        TextInput::make('outcalls_rate')
                            ->numeric()
                            ->prefix('Ksh'),
                        TextInput::make('other_cities')
                            ->columnSpanFull(),
                    ]),

                Section::make('Settings')
                    ->columns(3)
                    ->schema([
                        Select::make('favorites_visibility')
                            ->label('Favorites Visibility')
                            ->options([
                                'everybody' => 'Everybody',
                                'favourites' => 'Favourites Only',
                                'nobody' => 'Nobody',
                            ])
                            ->default('everybody'),
                        Select::make('photos_visibility')
                            ->label('Photos Visibility')
                            ->options([
                                'everybody' => 'Everybody',
                                'favourites' => 'Favourites Only',
                                'nobody' => 'Nobody',
                            ])
                            ->default('everybody'),
                        Select::make('email_notifications')
                            ->label('Email Notifications')
                            ->options([
                                'messages' => 'Messages',
                                'none' => 'None',
                            ])
                            ->default('messages'),
                    ]),

                Section::make('Subscription Plans')
                    ->columns(2)
                    ->schema([
                        Select::make('subscription_plan')
                            ->label('Profile Plan')
                            ->placeholder('No plan')
                            ->options([
                                'regular'   => 'Regular',
                                'vip'       => 'VIP',
                                'prime'     => 'Prime',
                                'prime_vip' => 'Prime VIP',
                            ])
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('subscription_expires_at', now()->addDays(30));
                                    $limits = match ($state) {
                                        'regular' => ['photo' => 4, 'video' => 0],
                                        'prime' => ['photo' => 6, 'video' => 2],
                                        'prime_vip' => ['photo' => 8, 'video' => 4],
                                        'vip' => ['photo' => 10, 'video' => 6],
                                        default => ['photo' => 0, 'video' => 0],
                                    };
                                    $set('photo_limit', $limits['photo']);
                                    $set('video_limit', $limits['video']);
                                } else {
                                    $set('subscription_expires_at', null);
                                    $set('photo_limit', 0);
                                    $set('video_limit', 0);
                                }
                            })
                            ->nullable(),
                        DateTimePicker::make('subscription_expires_at')
                            ->label('Profile Plan Expires At')
                            ->placeholder('Never (no expiry)')
                            ->nullable()
                            ->helperText('Leave blank for a non-expiring subscription.'),
                        
                        Select::make('chat_plan')
                            ->label('Chat Plan')
                            ->placeholder('No chat plan')
                            ->options([
                                '1 Day Chat Plan' => '1 Day Chat Plan',
                                '3 Day Chat Plan' => '3 Day Chat Plan',
                                '7 Days Chat Plan' => '7 Days Chat Plan',
                                '15 Days Chat Plan' => '15 Days Chat Plan',
                                '30 Days Chat Plan' => '30 Days Chat Plan',
                            ])
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    preg_match('/^(\d+)\s/', $state, $matches);
                                    $days = isset($matches[1]) ? (int) $matches[1] : 30;
                                    $set('chat_expires_at', now()->addDays($days));
                                } else {
                                    $set('chat_expires_at', null);
                                }
                            })
                            ->nullable(),
                        DateTimePicker::make('chat_expires_at')
                            ->label('Chat Plan Expires At')
                            ->placeholder('Never (no expiry)')
                            ->nullable(),
                        DateTimePicker::make('last_seen_at')
                            ->label('Last Seen At (Online Status)')
                            ->placeholder('Offline')
                            ->helperText('Set a future date to force this user to appear online.')
                            ->nullable(),
                    ]),
            ]);
    }
}