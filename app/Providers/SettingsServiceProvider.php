<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share settings to all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = \App\Models\Setting::getSettings();
            $view->with('settings', $settings);
        });
    }
}
