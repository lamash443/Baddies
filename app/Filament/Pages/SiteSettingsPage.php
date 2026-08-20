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

    public function mount(): void
    {
        $this->form->fill([
            // ── Branding ──────────────────────────────────────────────────────
            'logo'            => SiteSetting::get('logo'),
            'preloader'       => SiteSetting::get('preloader'),
            'favicon'         => SiteSetting::get('favicon'),

            // ── Hero Section ──────────────────────────────────────────────────
            'hero_title'      => SiteSetting::get('hero_title'),
            'hero_subtitle'   => SiteSetting::get('hero_subtitle'),
            'hero_background' => SiteSetting::get('hero_background'),

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
                            ->image()
                            ->disk('public')
                            ->directory('site')
                            ->imagePreviewHeight('80')
                            ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                            ->helperText('Recommended: PNG or SVG with transparent background.')
                            ->default(SiteSetting::get('logo')),
                    ]),

                Section::make('Favicon')
                    ->description('Upload the browser tab icon (favicon).')
                    ->schema([
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->directory('site')
                            ->imagePreviewHeight('48')
                            ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/ico', 'image/jpeg'])
                            ->helperText('Recommended: 32×32 or 64×64 PNG/ICO.')
                            ->default(SiteSetting::get('favicon')),
                    ]),

                Section::make('Preloader')
                    ->description('Upload the preloader image shown while the site loads.')
                    ->schema([
                        FileUpload::make('preloader')
                            ->label('Preloader Image')
                            ->image()
                            ->disk('public')
                            ->directory('site')
                            ->imagePreviewHeight('80')
                            ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/svg+xml', 'image/webp'])
                            ->helperText('GIF or animated WebP recommended.')
                            ->default(SiteSetting::get('preloader')),
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
                            ->label('Hero Background Image')
                            ->image()
                            ->disk('public')
                            ->directory('site')
                            ->imagePreviewHeight('150')
                            ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/webp'])
                            ->helperText('Best if a dark, high-resolution photo is used (e.g. 1920x1080). Leave empty to use the default image.')
                            ->default(SiteSetting::get('hero_background')),
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
                    ->description('Edit the section subtitle and each of the 4 step cards shown on the homepage.')
                    ->schema([
                        TextInput::make('hiw_subtitle')
                            ->label('Section Subtitle')
                            ->maxLength(255)
                            ->helperText('e.g. "Find your perfect match in 3 simple steps"'),

                        TextInput::make('hiw_step1_title')
                            ->label('Step 1 — Title')
                            ->maxLength(100),
                        Textarea::make('hiw_step1_body')
                            ->label('Step 1 — Description')
                            ->rows(2),

                        TextInput::make('hiw_step2_title')
                            ->label('Step 2 — Title')
                            ->maxLength(100),
                        Textarea::make('hiw_step2_body')
                            ->label('Step 2 — Description')
                            ->rows(2),

                        TextInput::make('hiw_step3_title')
                            ->label('Step 3 — Title')
                            ->maxLength(100),
                        Textarea::make('hiw_step3_body')
                            ->label('Step 3 — Description')
                            ->rows(2),

                        TextInput::make('hiw_step4_title')
                            ->label('Step 4 — Title')
                            ->maxLength(100),
                        Textarea::make('hiw_step4_body')
                            ->label('Step 4 — Description')
                            ->rows(2),
                    ]),

                // ── EDITORIAL / ABOUT SECTION ─────────────────────────────────────
                Section::make('Editorial / About Section')
                    ->description('Edit all text blocks in the editorial "About" section at the bottom of the homepage. Wrap text in <span>…</span> for the orange accent colour.')
                    ->schema([
                        Textarea::make('editorial_heading')
                            ->label('Main Heading (HTML allowed)')
                            ->rows(2)
                            ->helperText('Use <span>…</span> for orange accent. Example: "…looking for a way to <span>spice up your day</span>…"'),

                        Textarea::make('editorial_intro')
                            ->label('Intro Paragraph')
                            ->rows(4),

                        TextInput::make('editorial_local_title')
                            ->label('Sub-heading: Local Escorts')
                            ->maxLength(150),
                        Textarea::make('editorial_local_body')
                            ->label('Local Escorts — Body (separate paragraphs with a blank line)')
                            ->rows(6),

                        TextInput::make('editorial_services_title')
                            ->label('Sub-heading: Escort Services')
                            ->maxLength(150),
                        Textarea::make('editorial_services_body')
                            ->label('Services — Body (use "- item" on its own line for bullet points)')
                            ->rows(8),

                        TextInput::make('editorial_meet_title')
                            ->label('Sub-heading: Know Whom You Meet')
                            ->maxLength(150),
                        Textarea::make('editorial_meet_body')
                            ->label('Know Whom — Body (use "- item" on its own line for bullet points)')
                            ->rows(6),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $fileKeys = ['logo', 'preloader', 'favicon', 'hero_background'];

        $allKeys = [
            // Branding
            'logo', 'preloader', 'favicon',
            // Hero
            'hero_title', 'hero_subtitle', 'hero_background',
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
        ];

        foreach ($allKeys as $key) {
            $newValue = $data[$key] ?? null;
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
