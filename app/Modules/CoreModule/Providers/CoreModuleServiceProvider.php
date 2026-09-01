<?php

namespace App\Modules\CoreModule\Providers;

use Illuminate\Support\ServiceProvider;

class CoreModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register shared core services here.
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Shared Core module boot logic goes here.
    }
}
