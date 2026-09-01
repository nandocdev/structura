<?php

use App\Modules\CoreModule\Providers\CoreModuleServiceProvider;
use App\Modules\UserModule\Providers\UserModuleServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\HorizonServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    HorizonServiceProvider::class,
    CoreModuleServiceProvider::class,
    UserModuleServiceProvider::class,
];
