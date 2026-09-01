<?php

use App\Modules\CoreModule\Providers\CoreModuleServiceProvider;
use App\Modules\UserModule\Providers\UserModuleServiceProvider;

it('registers the core modular provider', function () {
    expect(app()->getProvider(CoreModuleServiceProvider::class))->not()->toBeNull();
});

it('defines the modular directory structure', function () {
    expect(file_exists(base_path('app/Modules/CoreModule')))->toBeTrue()
        ->and(file_exists(base_path('app/Modules/CoreModule/Providers')))->toBeTrue()
        ->and(file_exists(base_path('app/Modules/CoreModule/Actions')))->toBeTrue()
        ->and(file_exists(base_path('app/Modules/UserModule')))->toBeTrue()
        ->and(file_exists(base_path('app/Modules/UserModule/Models')))->toBeTrue()
        ->and(file_exists(base_path('app/Modules/UserModule/Providers')))->toBeTrue();
});

it('registers the user module provider', function () {
    expect(app()->getProvider(UserModuleServiceProvider::class))->not()->toBeNull();
});
