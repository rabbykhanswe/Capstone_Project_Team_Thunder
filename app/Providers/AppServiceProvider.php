<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

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
        // Share site settings with every view
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('site_settings')) {
                    $settings = SiteSetting::all_settings();
                    $defaults = SiteSetting::defaults();
                    $site = array_merge($defaults, $settings);
                    $view->with('site', $site);
                }
            } catch (\Exception $e) {
                $view->with('site', SiteSetting::defaults());
            }
        });
    }
}
