<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
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
        // Share active categories with all views
        View::composer('*', function ($view) {
            try {
                if (!array_key_exists('categories', $view->getData())) {
                    $categories = Category::active()->ordered()->get();
                    $view->with('categories', $categories);
                }
            } catch (\Exception $e) {
                if (!array_key_exists('categories', $view->getData())) {
                    $view->with('categories', collect());
                }
            }
        });
    }
}
