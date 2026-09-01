<?php

namespace App\Modules\UserModule\Providers;

use Illuminate\Support\ServiceProvider;

class UserModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // User module registration hooks.
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register views for the module
        $this->loadViewsFrom(
            resource_path('views'),
            'user-module'
        );

        // Register migrations, routes, etc. as needed
    }
}
