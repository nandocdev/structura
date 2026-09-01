<?php

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

it('configures the API guard for sanctum', function () {
   expect(config('auth.guards.api.driver'))->toBe('sanctum')
      ->and(config('auth.guards.api.provider'))->toBe('users');
});

it('allows local and admin users to access the monitoring dashboards', function () {
   Role::create(['name' => 'admin']);

   $admin = User::factory()->create();
   $admin->assignRole('admin');

   expect(Gate::check('viewHorizon', $admin))->toBeTrue()
      ->and(Gate::check('viewPulse', $admin))->toBeTrue();
});
