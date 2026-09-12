<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class SiteSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.site-settings';

    protected static string $routePath = 'settings';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    protected function getValidFileSetting(?string $key): ?string
    {
        $val = SiteSetting::get($key);
        if (! $val || trim($val) === '') {
            return null;
        }
        if (! Storage::disk('public')->exists($val)) {
            return null;
        }
        return $val;
    }

    public function mount(): void
    {
        $this->form->fill([
            // ── Branding ──────────────────────────────────────────────────────
            'logo'            => $this->getValidFileSetting('logo'),
            'preloader'       => $this->getValidFileSetting('preloader'),
            'favicon'         => $this->getValidFileSetting('favicon'),

            // ── Hero Section & Header Images ─────────────────────────────────
            'hero_title'                     => SiteSetting::get('hero_title'),
            'hero_subtitle'                  => SiteSetting::get('hero_subtitle'),
            'hero_background'                => $this->getValidFileSetting('hero_background'),
            'escort_girls_header_background' => $this->getValidFileSetting('escort_girls_header_background'),
            'call_boys_header_background'    => $this->getValidFileSetting('call_boys_header_background'),

            // ── Call Girls Section ────────────────────────────────────────────
            'call_girls_subtitle' => SiteSetting::get('call_girls_subtitle', 'Verified escorts and call girls across Kenya'),

            // ── Classifieds Section ───────────────────────────────────────────
            'classifieds_subtitle' => SiteSetting::get('classifieds_subtitle', 'Personals, jobs, and adult services'),

            // ── How It Works Section ──────────────────────────────────────────
            'hiw_subtitle'    => SiteSetting::get('hiw_subtitle', 'Find your perfect match in 3 simple steps'),
            'hiw_step1_title' => SiteSetting::get('hiw_step1_title', 'Browse Profiles'),
            'hiw_step1_body'  => SiteSetting::get('hiw_step1_body', 'Browse hundreds of verified escorts and call girls near you. Filter by location, price, or category.'),
            'hiw_step2_title' => SiteSetting::get('hiw_step2_title', 'View Profile'),
            'hiw_step2_body'  => SiteSetting::get('hiw_step2_body', 'See full details — photos, rates, services, and location. Everything you need to make the right choice.'),
            'hiw_step3_title' => SiteSetting::get('hiw_step3_title', 'Connect Directly'),
            'hiw_step3_body'  => SiteSetting::get('hiw_step3_body', 'Reach out directly via the profile contact details. No middlemen, no delays — just direct connection.'),
            'hiw_step4_title' => SiteSetting::get('hiw_step4_title', 'Enjoy VIP Perks'),
            'hiw_step4_body'  => SiteSetting::get('hiw_step4_body', 'Upgrade to VIP to unlock priority visibility, more photos, videos, and exclusive features.'),

            // ── Editorial / About Section ──────────────────────────────────────
            'editorial_heading'        => SiteSetting::get('editorial_heading', 'If you are in Kenya and looking for a way to <span>spice up your day or night</span>, you are lucky to have landed in Baddies‑Club.'),
            'editorial_intro'          => SiteSetting::get('editorial_intro', "We are a Kenyan escort agency that crafts pleasurable moments for men and women across the country. What pleasure means is totally up to you. Committed to creating authentic Raha vibes, our escort girls are up to anything you can envision in companionship, relaxation, and sexual terms. It's time to spend a day you'll never forget!"),
            'editorial_local_title'    => SiteSetting::get('editorial_local_title', 'Local Escorts and Call Girls in Kenya'),
            'editorial_local_body'     => SiteSetting::get('editorial_local_body', "You may be enjoying Kenyan national parks and African flavors a lot, but it is the local female beauties that make the country one to remember. Most of our girls are Kenyans who are well aware of the real meaning behind Raha and who can do it all for your contentment and sexual delight.\n\nSpend your time while accompanied by passionate Kenya sex escorts and indulge in their pristine beauty. Let them arrange a VIP experience just for you at any place of your choice, as long as they cover the selected area.\n\nBesides Kenyan girls, you are in good company with Eritrean, Egyptian, Ethiopian, Ugandan, and Tanzanian escorts. You can meet them all directly on this website."),
            'editorial_services_title' => SiteSetting::get('editorial_services_title', 'A Wide Range of Escort Services in Kenya'),
            'editorial_services_body'  => SiteSetting::get('editorial_services_body', "Your wish is our escort girls' command. Whether you are bored, want to blow off some steam, or are thirsty for extraordinary sexual experiences, you only need to find the right lady to accompany you.\n\nHere's a glimpse at the Kenya escort services you can receive with Baddies\u2011Club:\n- Massage services that get as erotic as you can imagine\n- Luxury and VIP companionship (events or private)\n- Erotic dancing that will leave you speechless\n- Video calls and remote ways of satisfying your desires\n- Incall and outcall sex services\n\nEnjoy time with your escort in a way you're comfortable with. Whether you want her to come over to your place or get away from the usual surroundings, we are at your service."),
            'editorial_meet_title'     => SiteSetting::get('editorial_meet_title', "Know Whom You're Going to Meet"),
            'editorial_meet_body'      => SiteSetting::get('editorial_meet_body', "Our escorts in Kenya are hot, but you don't have to take our word for it. The portfolio of every service provider on Baddies\u2011Club is complete with appearance details and photos, so you can let your eyes choose. These are verified to minimize the risk of unexpected encounters and unwanted surprises on the meeting day.\n\nAs you get familiar with a call girl's portfolio, you'll also discover:\n- Everything she is ready (and isn't ready) to do for you\n- The list of areas covered\n- The fees she would charge for her escort services\n- Contact information"),

            // ── PayHero Payment Gateway ─────────────────────────────────────────
            'payhero_username'     => SiteSetting::get('payhero_username', config('services.payhero.username')),
            'payhero_password'     => SiteSetting::get('payhero_password', config('services.payhero.password')),
            'payhero_auth_token'   => SiteSetting::get('payhero_auth_token', config('services.payhero.auth_token')),
            'payhero_channel_id'   => SiteSetting::get('payhero_channel_id', config('services.payhero.channel_id')),
            'payhero_account_id'   => SiteSetting::get('payhero_account_id', config('services.payhero.account_id')),
            'payhero_callback_url' => SiteSetting::get('payhero_callback_url', config('services.payhero.callback_url')),

            // ── Google OAuth Login Settings ────────────────────────────────────
            'google_client_id'     => SiteSetting::get('google_client_id', config('services.google.client_id')),
            'google_client_secret' => SiteSetting::get('google_client_secret', config('services.google.client_secret')),
            'google_redirect_uri'  => SiteSetting::get('google_redirect_uri', config('services.google.redirect', url('/auth/google/callback'))),

            // ── SMTP Mail Settings ─────────────────────────────────────────────
            'mail_mailer'       => SiteSetting::get('mail_mailer', config('mail.default', 'smtp')),
            'mail_host'         => SiteSetting::get('mail_host', config('mail.mailers.smtp.host', '')),
            'mail_port'         => SiteSetting::get('mail_port', config('mail.mailers.smtp.port', '587')),
            'mail_encryption'   => SiteSetting::get('mail_encryption', config('mail.mailers.smtp.encryption', 'tls')),
            'mail_username'     => SiteSetting::get('mail_username', config('mail.mailers.smtp.username', '')),
            'mail_password'     => SiteSetting::get('mail_password', config('mail.mailers.smtp.password', '')),
            'mail_from_address' => SiteSetting::get('mail_from_address', config('mail.from.address', '')),
            'mail_from_name'    => SiteSetting::get('mail_from_name', config('mail.from.name', 'Baddies Club')),

            // ── Welcome Email Template ──────────────────────────────────────────
            'welcome_email_subject'        => SiteSetting::get('welcome_email_subject', 'Welcome to Kenyan Baddies Club – Please Verify Your Email'),
            'welcome_email_subheading'     => SiteSetting::get('welcome_email_subheading', "Your account has been created. You're now part of Kenya's most exclusive companion network."),
            'welcome_email_body'           => SiteSetting::get('welcome_email_body', "We're thrilled to have you join Kenyan Baddies Club — a premium, members-only platform connecting Kenya's most exclusive companions with discerning clients.\n\nTo activate your account and unlock full access, please verify your email address by clicking the button below. Your verification link expires in 60 minutes."),
            'welcome_email_button_text'    => SiteSetting::get('welcome_email_button_text', '✅ Verify My Email Address'),
            'welcome_email_brand_tagline'  => SiteSetting::get('welcome_email_brand_tagline', "Kenya's Premier Companion Network"),
            // Feature highlights
            'welcome_email_feat1_title'    => SiteSetting::get('welcome_email_feat1_title', 'VIP Profiles'),
            'welcome_email_feat1_desc'     => SiteSetting::get('welcome_email_feat1_desc', 'Stand out with premium tier placement'),
            'welcome_email_feat2_title'    => SiteSetting::get('welcome_email_feat2_title', 'Verified Badge'),
            'welcome_email_feat2_desc'     => SiteSetting::get('welcome_email_feat2_desc', 'Build trust with a real photo badge'),
            'welcome_email_feat3_title'    => SiteSetting::get('welcome_email_feat3_title', 'Private Chat'),
            'welcome_email_feat3_desc'     => SiteSetting::get('welcome_email_feat3_desc', 'Message members discreetly & securely'),
            // Onboarding steps
            'welcome_email_step1_title'    => SiteSetting::get('welcome_email_step1_title', 'Verify Your Email'),
            'welcome_email_step1_desc'     => SiteSetting::get('welcome_email_step1_desc', 'Click the button below to confirm your address and fully activate your account.'),
            'welcome_email_step2_title'    => SiteSetting::get('welcome_email_step2_title', 'Complete Your Profile'),
            'welcome_email_step2_desc'     => SiteSetting::get('welcome_email_step2_desc', 'Add photos, set your location, list your services, and personalise your listing.'),
            'welcome_email_step3_title'    => SiteSetting::get('welcome_email_step3_title', 'Choose a Membership Plan'),
            'welcome_email_step3_desc'     => SiteSetting::get('welcome_email_step3_desc', 'Go VIP, Prime VIP, or Regular to get featured and start receiving clients.'),
            // Security notice
            'welcome_email_security_note'  => SiteSetting::get('welcome_email_security_note', 'If you did not create this account, simply ignore this email. Your email address will not be linked to any profile without verification. No further action is needed.'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([

                // ── BRANDING ──────────────────────────────────────────────────────
                Section::make('Logo')
                    ->description('Upload the site logo. Used in the navigation bar and emails.')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Site Logo')
                            ->disk('public')
                            ->directory('site')
                            ->image(),
                    ]),

                Section::make('Favicon')
                    ->description('Upload the browser tab icon (favicon).')
                    ->schema([
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->disk('public')
                            ->directory('site')
                            ->image(),
                    ]),

                Section::make('Preloader')
                    ->description('Upload the preloader image shown while the site loads.')
                    ->schema([
                        FileUpload::make('preloader')
                            ->label('Preloader Image')
                            ->disk('public')
                            ->directory('site')
                            ->image(),
                    ]),

                // ── HERO SECTION ──────────────────────────────────────────────────
                Section::make('Hero Section (Header)')
                    ->description('Manage the hero background and main introductory text.')
                    ->schema([
                        TextInput::make('hero_title')
                            ->label('Hero Title')
                            ->required()
                            ->maxLength(255)
                            ->helperText('HTML tags like <span> and <br> are allowed for accent colors & formatting.'),
                        Textarea::make('hero_subtitle')
                            ->label('Hero Subtitle')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000),
                        FileUpload::make('hero_background')
                            ->label('Homepage Hero Background Image (http://127.0.0.1:8000/)')
                            ->disk('public')
                            ->directory('site')
                            ->image(),
                        FileUpload::make('escort_girls_header_background')
                            ->label('Escort Girls Header Image (http://127.0.0.1:8000/escort-girls)')
                            ->disk('public')
                            ->directory('site')
                            ->image(),
                        FileUpload::make('call_boys_header_background')
                            ->label('Call Boys Header Image (http://127.0.0.1:8000/category/call-boys)')
                            ->disk('public')
                            ->directory('site')
                            ->image(),
                    ]),

                // ── CALL GIRLS SECTION ────────────────────────────────────────────
                Section::make('Call Girls Section')
                    ->description('Edit the subtitle shown beneath the "Call Girls" heading on the homepage.')
                    ->schema([
                        TextInput::make('call_girls_subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->helperText('e.g. "Verified escorts and call girls across Kenya"'),
                    ]),

                // ── CLASSIFIEDS SECTION ───────────────────────────────────────────
                Section::make('Adult Classifieds Section')
                    ->description('Edit the subtitle shown beneath the "Adult Classifieds" heading on the homepage.')
                    ->schema([
                        TextInput::make('classifieds_subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->helperText('e.g. "Personals, jobs, and adult services"'),
                    ]),

                // ── HOW IT WORKS ──────────────────────────────────────────────────
                Section::make('How It Works Section')
                    ->description('Manage the 4-step process content shown on the homepage.')
                    ->schema([
                        TextInput::make('hiw_subtitle')
                            ->label('Section Subtitle')
                            ->maxLength(255),
                        TextInput::make('hiw_step1_title')->label('Step 1 Title'),
                        Textarea::make('hiw_step1_body')->label('Step 1 Description')->rows(2),
                        TextInput::make('hiw_step2_title')->label('Step 2 Title'),
                        Textarea::make('hiw_step2_body')->label('Step 2 Description')->rows(2),
                        TextInput::make('hiw_step3_title')->label('Step 3 Title'),
                        Textarea::make('hiw_step3_body')->label('Step 3 Description')->rows(2),
                        TextInput::make('hiw_step4_title')->label('Step 4 Title'),
                        Textarea::make('hiw_step4_body')->label('Step 4 Description')->rows(2),
                    ]),

                // ── EDITORIAL / ABOUT SECTION ─────────────────────────────────────
                Section::make('Homepage Editorial / About Text')
                    ->description('Manage the SEO text blocks at the bottom of the homepage.')
                    ->schema([
                        Textarea::make('editorial_heading')
                            ->label('Main Banner Heading (HTML allowed)')
                            ->rows(2),
                        Textarea::make('editorial_intro')
                            ->label('Main Banner Intro Text')
                            ->rows(3),
                        TextInput::make('editorial_local_title')
                            ->label('Local Escorts Section Title'),
                        Textarea::make('editorial_local_body')
                            ->label('Local Escorts Section Body')
                            ->rows(5),
                        TextInput::make('editorial_services_title')
                            ->label('Services Section Title'),
                        Textarea::make('editorial_services_body')
                            ->label('Services Section Body (use "- item" on its own line for bullet points)')
                            ->rows(6),
                        TextInput::make('editorial_meet_title')
                            ->label('Know Whom — Section Title'),
                        Textarea::make('editorial_meet_body')
                            ->label('Know Whom — Body (use "- item" on its own line for bullet points)')
                            ->rows(6),
                    ]),

                // ── PAYHERO PAYMENT GATEWAY ───────────────────────────────────────
                Section::make('PayHero M-Pesa Payment Credentials')
                    ->description('Manage PayHero API credentials, Channel ID, Account ID, and Webhook Callback URL for M-Pesa automated payments.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('payhero_username')
                            ->label('PayHero Username')
                            ->placeholder('e.g. IlvxJNuM91zkYWIdu8jN')
                            ->maxLength(255),
                        TextInput::make('payhero_password')
                            ->label('PayHero Password')
                            ->password()
                            ->revealable()
                            ->maxLength(255),
                        TextInput::make('payhero_auth_token')
                            ->label('PayHero Auth Token (Basic Auth Base64)')
                            ->password()
                            ->revealable()
                            ->columnSpanFull()
                            ->helperText('Optional pre-encoded Base64 string (Username:Password). If left blank, it will be automatically computed.'),
                        TextInput::make('payhero_channel_id')
                            ->label('PayHero Channel ID')
                            ->placeholder('e.g. 11727')
                            ->maxLength(255),
                        TextInput::make('payhero_account_id')
                            ->label('PayHero Account ID')
                            ->placeholder('e.g. 7806')
                            ->maxLength(255),
                        TextInput::make('payhero_callback_url')
                            ->label('PayHero Callback / Webhook URL')
                            ->url()
                            ->columnSpanFull()
                            ->placeholder('https://endif-ruth-digest-veterans.trycloudflare.com/webhook/payhero')
                            ->helperText('Public URL where PayHero sends M-Pesa payment status webhooks.'),
                    ]),

                // ── GOOGLE OAUTH SETTINGS ─────────────────────────────────────────
                Section::make('Google OAuth Authentication')
                    ->description('Configure Google Client ID and Secret to enable "Login with Google" on the login & sign-up popups.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('google_client_id')
                            ->label('Google Client ID')
                            ->placeholder('e.g. 123456789-abc.apps.googleusercontent.com')
                            ->columnSpanFull()
                            ->maxLength(255),
                        TextInput::make('google_client_secret')
                            ->label('Google Client Secret')
                            ->password()
                            ->revealable()
                            ->columnSpanFull()
                            ->maxLength(255),
                        TextInput::make('google_redirect_uri')
                            ->label('Google OAuth Redirect URI')
                            ->url()
                            ->columnSpanFull()
                            ->placeholder(url('/auth/google/callback'))
                            ->helperText('The Authorized Redirect URI registered in Google Cloud Console.'),
                    ]),

                // ── SMTP MAIL SETTINGS ────────────────────────────────────────────
                Section::make('SMTP Mail / Email Settings')
                    ->description('Configure the outgoing mail server used for sending emails to users. Required for the Broadcast Email feature.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('mail_mailer')
                            ->label('Mail Driver')
                            ->placeholder('smtp')
                            ->default('smtp')
                            ->required()
                            ->helperText('Options: smtp, sendmail, log (testing). Use "smtp" for Gmail, Mailgun, Postmark.'),

                        TextInput::make('mail_encryption')
                            ->label('Encryption')
                            ->placeholder('tls')
                            ->default('tls')
                            ->helperText('Options: tls (port 587) · ssl (port 465) · leave blank for none.'),

                        TextInput::make('mail_host')
                            ->label('SMTP Host')
                            ->placeholder('smtp.gmail.com')
                            ->helperText('e.g. smtp.gmail.com, smtp.mailgun.org')
                            ->maxLength(255),

                        TextInput::make('mail_port')
                            ->label('SMTP Port')
                            ->placeholder('587')
                            ->helperText('Common: 587 (TLS) or 465 (SSL)')
                            ->maxLength(10),

                        TextInput::make('mail_username')
                            ->label('SMTP Username / Email')
                            ->placeholder('your@gmail.com')
                            ->maxLength(255),

                        TextInput::make('mail_password')
                            ->label('SMTP Password / App Password')
                            ->password()
                            ->revealable()
                            ->maxLength(255)
                            ->helperText('For Gmail: use an App Password (not your main password).'),

                        TextInput::make('mail_from_address')
                            ->label('From Email Address')
                            ->placeholder('noreply@baddiesclub.com')
                            ->email()
                            ->columnSpanFull()
                            ->maxLength(255),

                        TextInput::make('mail_from_name')
                            ->label('From Name')
                            ->placeholder('Baddies Club')
                            ->columnSpanFull()
                            ->maxLength(255)
                            ->helperText('The sender name users will see in their inbox.'),
                    ]),

                // ── WELCOME EMAIL TEMPLATE ────────────────────────────────────────
                Section::make('Welcome Email Template')
                    ->description('Customise every part of the automatic welcome email sent to new members on sign-up. Changes take effect immediately for all future registrations.')
                    ->schema([

                        // — Core fields —
                        Section::make('Core Content')
                            ->description('The subject line, hero subtitle, and main body text of the email.')
                            ->compact()
                            ->schema([
                                TextInput::make('welcome_email_subject')
                                    ->label('Email Subject Line')
                                    ->placeholder('Welcome to Kenyan Baddies Club – Please Verify Your Email')
                                    ->maxLength(255)
                                    ->columnSpanFull()
                                    ->helperText('This is what users see in their inbox before opening the email.'),

                                TextInput::make('welcome_email_subheading')
                                    ->label('Hero Subtitle')
                                    ->placeholder("Your account has been created. You're now part of Kenya's most exclusive companion network.")
                                    ->maxLength(400)
                                    ->columnSpanFull()
                                    ->helperText('Appears below the "Welcome to the Inner Circle" hero heading.'),

                                Textarea::make('welcome_email_body')
                                    ->label('Intro Body Message')
                                    ->rows(5)
                                    ->columnSpanFull()
                                    ->helperText('Shown after the personalised greeting. Use blank lines to separate paragraphs.'),

                                TextInput::make('welcome_email_button_text')
                                    ->label('Verify Button Text')
                                    ->placeholder('✅ Verify My Email Address')
                                    ->maxLength(100)
                                    ->helperText('Text on the orange CTA verification button.'),

                                TextInput::make('welcome_email_brand_tagline')
                                    ->label('Brand Tagline')
                                    ->placeholder("Kenya's Premier Companion Network")
                                    ->maxLength(100)
                                    ->helperText('Small tagline shown below the brand name in the email header.'),
                            ])->columns(2),

                        // — Feature Highlights —
                        Section::make('Feature Highlights (3 Icon Tiles)')
                            ->description('The three feature tiles shown in the email — edit their titles and short descriptions.')
                            ->compact()
                            ->schema([
                                TextInput::make('welcome_email_feat1_title')
                                    ->label('Feature 1 Title (💎)')
                                    ->placeholder('VIP Profiles')
                                    ->maxLength(60),
                                TextInput::make('welcome_email_feat1_desc')
                                    ->label('Feature 1 Description')
                                    ->placeholder('Stand out with premium tier placement')
                                    ->maxLength(120),

                                TextInput::make('welcome_email_feat2_title')
                                    ->label('Feature 2 Title (✅)')
                                    ->placeholder('Verified Badge')
                                    ->maxLength(60),
                                TextInput::make('welcome_email_feat2_desc')
                                    ->label('Feature 2 Description')
                                    ->placeholder('Build trust with a real photo badge')
                                    ->maxLength(120),

                                TextInput::make('welcome_email_feat3_title')
                                    ->label('Feature 3 Title (💬)')
                                    ->placeholder('Private Chat')
                                    ->maxLength(60),
                                TextInput::make('welcome_email_feat3_desc')
                                    ->label('Feature 3 Description')
                                    ->placeholder('Message members discreetly & securely')
                                    ->maxLength(120),
                            ])->columns(2),

                        // — Onboarding Steps —
                        Section::make('Onboarding Steps ("Get Started in 3 Steps")')
                            ->description('The numbered step-by-step guide that walks new members through getting started.')
                            ->compact()
                            ->schema([
                                TextInput::make('welcome_email_step1_title')
                                    ->label('Step 1 Title')
                                    ->placeholder('Verify Your Email')
                                    ->maxLength(80),
                                Textarea::make('welcome_email_step1_desc')
                                    ->label('Step 1 Description')
                                    ->rows(2)
                                    ->placeholder('Click the button below to confirm your address and fully activate your account.'),

                                TextInput::make('welcome_email_step2_title')
                                    ->label('Step 2 Title')
                                    ->placeholder('Complete Your Profile')
                                    ->maxLength(80),
                                Textarea::make('welcome_email_step2_desc')
                                    ->label('Step 2 Description')
                                    ->rows(2)
                                    ->placeholder('Add photos, set your location, list your services, and personalise your listing.'),

                                TextInput::make('welcome_email_step3_title')
                                    ->label('Step 3 Title')
                                    ->placeholder('Choose a Membership Plan')
                                    ->maxLength(80),
                                Textarea::make('welcome_email_step3_desc')
                                    ->label('Step 3 Description')
                                    ->rows(2)
                                    ->placeholder('Go VIP, Prime VIP, or Regular to get featured and start receiving clients.'),
                            ])->columns(2),

                        // — Security Notice —
                        Section::make('Security / Footer Notice')
                            ->description('Displayed at the bottom of the email for users who did not register.')
                            ->compact()
                            ->schema([
                                Textarea::make('welcome_email_security_note')
                                    ->label('Security Notice Text')
                                    ->rows(3)
                                    ->columnSpanFull()
                                    ->placeholder('If you did not create this account, simply ignore this email...'),
                            ]),

                    ])->columns(1),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $fileKeys = ['logo', 'preloader', 'favicon', 'hero_background', 'escort_girls_header_background', 'call_boys_header_background'];

        $allKeys = [
            // Branding
            'logo', 'preloader', 'favicon',
            // Hero & Headers
            'hero_title', 'hero_subtitle', 'hero_background',
            'escort_girls_header_background', 'call_boys_header_background',
            // Call Girls
            'call_girls_subtitle',
            // Classifieds
            'classifieds_subtitle',
            // How It Works
            'hiw_subtitle',
            'hiw_step1_title', 'hiw_step1_body',
            'hiw_step2_title', 'hiw_step2_body',
            'hiw_step3_title', 'hiw_step3_body',
            'hiw_step4_title', 'hiw_step4_body',
            // Editorial
            'editorial_heading', 'editorial_intro',
            'editorial_local_title', 'editorial_local_body',
            'editorial_services_title', 'editorial_services_body',
            'editorial_meet_title', 'editorial_meet_body',
            // PayHero Payment Gateway
            'payhero_username', 'payhero_password',
            'payhero_auth_token', 'payhero_channel_id',
            'payhero_account_id', 'payhero_callback_url',
            // Google OAuth
            'google_client_id', 'google_client_secret', 'google_redirect_uri',
            // SMTP Mail
            'mail_mailer', 'mail_host', 'mail_port', 'mail_encryption',
            'mail_username', 'mail_password', 'mail_from_address', 'mail_from_name',
            // Welcome Email Template
            'welcome_email_subject', 'welcome_email_subheading',
            'welcome_email_body', 'welcome_email_button_text',
            'welcome_email_brand_tagline',
            'welcome_email_feat1_title', 'welcome_email_feat1_desc',
            'welcome_email_feat2_title', 'welcome_email_feat2_desc',
            'welcome_email_feat3_title', 'welcome_email_feat3_desc',
            'welcome_email_step1_title', 'welcome_email_step1_desc',
            'welcome_email_step2_title', 'welcome_email_step2_desc',
            'welcome_email_step3_title', 'welcome_email_step3_desc',
            'welcome_email_security_note',
        ];

        foreach ($allKeys as $key) {
            $newValue = $data[$key] ?? null;

            if (in_array($key, $fileKeys) && is_array($newValue)) {
                $newValue = reset($newValue) ?: null;
            }

            $oldValue = SiteSetting::get($key);

            // Delete old file only for file-upload fields
            if (in_array($key, $fileKeys) && $oldValue && $oldValue !== $newValue && Storage::disk('public')->exists($oldValue)) {
                Storage::disk('public')->delete($oldValue);
            }

            SiteSetting::set($key, $newValue);
        }

        \Illuminate\Support\Facades\Cache::forget('site_settings');

        Notification::make()
            ->title('Site settings saved successfully!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save')
                ->icon(Heroicon::OutlinedCheckCircle),
        ];
    }
}
