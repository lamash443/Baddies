<?php

namespace App\Providers;

use App\Http\View\Composers\SiteSettingsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inject site settings (logo, favicon, preloader) into every view
        View::composer('*', SiteSettingsComposer::class);
    }
}
