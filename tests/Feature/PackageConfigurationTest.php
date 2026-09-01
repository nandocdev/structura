<?php

use Illuminate\Support\Facades\Gate;

it('configures the API guard for sanctum', function () {
    expect(config('auth.guards.api.driver'))->toBe('sanctum')
        ->and(config('auth.guards.api.provider'))->toBe('users');
});

it('registers the monitoring dashboard gates', function () {
    expect(Gate::has('viewHorizon'))->toBeTrue()
        ->and(Gate::has('viewPulse'))->toBeTrue();
});
