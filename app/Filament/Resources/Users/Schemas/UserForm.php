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
use App\Models\Location;

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
                        Toggle::make('calls_enabled')
                            ->label('Calls Enabled')
                            ->helperText('Allows users to call this profile.'),
                        Toggle::make('is_profile_hidden')
                            ->label('Hide Profile from Public')
                            ->helperText('Hides this profile from public listings and search even if active subscription exists.'),
                        DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->placeholder('Unverified')
                            ->nullable(),
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

                Section::make('Referrals')
                    ->columns(2)
                    ->schema([
                        TextInput::make('referral_code')
                            ->maxLength(255),
                        Select::make('referred_by_id')
                            ->label('Referred By')
                            ->relationship('referrer', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('referral_balance')
                            ->label('Referral Balance (Ksh)')
                            ->numeric()
                            ->default(0.00)
                            ->prefix('Ksh'),
                        TextInput::make('total_referral_earnings')
                            ->label('Total Referral Earnings (Ksh)')
                            ->numeric()
                            ->default(0.00)
                            ->prefix('Ksh'),
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
                            ->options(function () {
                                $static = ['Nairobi','Mombasa','Nakuru','Kiambu','Kisumu','Machakos','Kajiado','Uasin Gishu','Kilifi','Meru','Nyeri','Embu','Kakamega','Bungoma','Bomet','Kisii','Migori','Homa Bay','Siaya','Vihiga','Trans Nzoia','Nandi','Elgeyo Marakwet','Baringo','Laikipia','Nyandarua',"Murang'a",'Kirinyaga','Tharaka Nithi','Isiolo','Garissa','Wajir','Mandera','Marsabit','Samburu','Turkana','West Pokot','Lamu','Taita Taveta','Kwale','Tana River','Narok','Kericho','Nyamira','Rachuonyo'];
                                $db = Location::where('is_active', true)->where('type', 'county')->orderBy('name')->pluck('name')->toArray();
                                $all = array_unique(array_merge($static, $db));
                                sort($all);
                                return array_combine($all, $all);
                            })
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('County Name')
                                    ->required()
                                    ->maxLength(100),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $location = Location::firstOrCreate(
                                    ['name' => $data['name']],
                                    ['type' => 'county', 'is_active' => true]
                                );
                                return $location->name;
                            })
                            ->nullable(),
                        TextInput::make('city_town'),
                        Select::make('location')
                            ->options(function () {
                                $static = ['James Gichuru Road','Southern Bypass','Gitanga Road','Naivasha Road','Northern Bypass','Eastern Bypass','Manyanja Rd','Waiyaki Way','Kiambu Road','Langata Road','Outering Road','Kangundo Road','Ngong Road','Kamiti Road','Jogoo Road','Mombasa Road','Thika Road','Allsops','Banana','Buruburu','Chokaa','Dagoretti','Dandora','Donholm','Eastlands','Eastleigh','Embakasi','Garden City','Githurai 44','Githurai 45','Homeland','Hurlingham','Huruma','Imara Daima','Jamhuri','Joska','Juja','Kabete','Kahawa Sukari','Kahawa Wendani','Kahawa West','Kamulu','Kangemi','Karen','Kariobangi','Kasarani','Kawangware','Kayole','Kenyatta Road','Kibera','Kikuyu','Kileleshwa','Kilimani','Kitengela','Kitisuru','Komarock','Langata','Lavington','Loresho','Madaraka','Makadara','Malaa','Mathare','Milimani','Mlolongo','Muthaiga','Muthangari','Muthurwa','Mwiki','Nairobi Town','Nairobi West','Ndenderu','Ngara','Ngong','Ngumba','Njiru','Pangani','Parklands','Roasters','Ongata Rongai','Roysambu','Ruai','Ruaka','Ruaraka','Ruiru','Runda','Saika','South B','South C','Syokimau','Thogoto','Thome','Umoja','Upper Hill','Utawala','Uthiru','Westlands'];
                                $db = Location::where('is_active', true)->whereIn('type', ['road', 'area'])->orderBy('name')->pluck('name')->toArray();
                                $all = array_unique(array_merge($static, $db));
                                sort($all);
                                return array_combine($all, $all);
                            })
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Location / Area Name')
                                    ->required()
                                    ->maxLength(100),
                                Select::make('type')
                                    ->label('Type')
                                    ->options(['area' => 'Area', 'road' => 'Road'])
                                    ->default('area')
                                    ->required(),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $location = Location::firstOrCreate(
                                    ['name' => $data['name']],
                                    ['type' => $data['type'] ?? 'area', 'is_active' => true]
                                );
                                return $location->name;
                            })
                            ->nullable(),
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
                            ->prefix('Ksh')
                            ->placeholder('Defaults to ASK if empty'),
                        TextInput::make('outcalls_rate')
                            ->numeric()
                            ->prefix('Ksh')
                            ->placeholder('Defaults to ASK if empty'),
                        TextInput::make('other_cities')
                            ->columnSpanFull(),
                        Textarea::make('additional_information')
                            ->label('Additional Information')
                            ->helperText('Appealing information displayed on the user profile to attract clients (no title shown on the public profile).')
                            ->rows(4)
                            ->maxLength(2500)
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