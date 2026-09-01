<?php

declare(strict_types=1);

use App\Modules\TaskModule\Http\Controllers\Api\V1\TaskApiController;
use App\Modules\UserModule\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Monolito Modular
|--------------------------------------------------------------------------
| Prefijo automático /api (bootstrap/app.php). Versionado v1.
| Cada módulo registra sus recursos aquí; para módulos grandes extraer a
| routes/api/v1/*.php e incluir con require.
*/

Route::prefix('v1')->group(function (): void {
    // Público (si aplica) — ejemplo health
    Route::get('/health', fn () => response()->json(['status' => 'ok']))->name('api.v1.health');

    // User
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return new UserResource($request->user());
    })->name('api.v1.user');

    // Tasks — Sanctum + throttle + verified opcional
    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function (): void {
        Route::apiResource('tasks', TaskApiController::class)->names([
            'index' => 'api.v1.tasks.index',
            'store' => 'api.v1.tasks.store',
            'show' => 'api.v1.tasks.show',
            'update' => 'api.v1.tasks.update',
            'destroy' => 'api.v1.tasks.destroy',
        ]);
    });
});
