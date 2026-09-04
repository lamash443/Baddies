<?php

namespace App\Http\View\Composers;

use App\Models\SiteSetting;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class SiteSettingsComposer
{
    protected array $settings;

    public function __construct()
    {
        // Load once per request; cache avoids DB hits across requests
        $this->settings = Cache::remember('site_settings', 3600, function () {
            return [
                'logo'                           => SiteSetting::get('logo'),
                'favicon'                        => SiteSetting::get('favicon'),
                'preloader'                      => SiteSetting::get('preloader'),
                'hero_title'                     => SiteSetting::get('hero_title'),
                'hero_subtitle'                  => SiteSetting::get('hero_subtitle'),
                'hero_background'                => SiteSetting::get('hero_background'),
                'escort_girls_header_background' => SiteSetting::get('escort_girls_header_background'),
                'call_boys_header_background'    => SiteSetting::get('call_boys_header_background'),
            ];
        });
    }

    public function compose(View $view): void
    {
        $view->with('siteSettings', $this->settings);
    }
}
