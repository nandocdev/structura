<?php

namespace App\Modules\UserModule\Providers;

use App\Modules\UserModule\Models\User;
use App\Modules\UserModule\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
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
        $this->loadViewsFrom(
            resource_path('views'),
            'user-module'
        );

        Gate::policy(User::class, UserPolicy::class);
    }
}
