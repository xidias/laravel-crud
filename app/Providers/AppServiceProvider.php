<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import the View facade
use Illuminate\Pagination\Paginator;

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
        $this->app->register(UserComposerServiceProvider::class);
        // Register svg component globally
        View::share('svg', 'components.svg');
        Paginator::useBootstrap(); // For Bootstrap 5
    }
}
