<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
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
            'logo'      => SiteSetting::get('logo'),
            'preloader' => SiteSetting::get('preloader'),
            'favicon'   => SiteSetting::get('favicon'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
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
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (['logo', 'preloader', 'favicon'] as $key) {
            $newValue = $data[$key] ?? null;
            $oldValue = SiteSetting::get($key);
            
            // Delete old file if it has changed (or was removed)
            if ($oldValue && $oldValue !== $newValue && Storage::disk('public')->exists($oldValue)) {
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
