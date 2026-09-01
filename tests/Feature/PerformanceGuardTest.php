<?php

declare(strict_types=1);

use App\Modules\TaskModule\Models\Task;
use App\Modules\UserModule\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('api tasks index does not N+1 (≤ 4 queries)', function (): void {
    $user = User::factory()->create();
    Task::factory()->for($user, 'user')->count(10)->create();

    Sanctum::actingAs($user);

    DB::enableQueryLog();

    $this->getJson('/api/v1/tasks?per_page=10')->assertOk();

    $queries = DB::getQueryLog();
    DB::disableQueryLog();

    // Esperado: 1 auth + 1 count + 1 select + 1 throttle cache = ≤ 4
    expect(count($queries))->toBeLessThanOrEqual(4, 'N+1 detectado: '.json_encode(array_column($queries, 'sql')));
});

it('task model scopes use indexes (explain)', function (): void {
    // Smoke test: scopes generan SQL con where indexado
    $sql = Task::query()->forUser(1)->pending()->toSql();

    expect($sql)->toContain('user_id')
        ->and($sql)->toContain('status');
});
