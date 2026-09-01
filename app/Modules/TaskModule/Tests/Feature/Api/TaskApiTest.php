<?php

declare(strict_types=1);

use App\Modules\TaskModule\Enums\TaskStatus;
use App\Modules\TaskModule\Events\TaskCreated;
use App\Modules\TaskModule\Events\TaskDeleted;
use App\Modules\TaskModule\Events\TaskUpdated;
use App\Modules\TaskModule\Models\Task;
use App\Modules\UserModule\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('requires authentication for api', function (): void {
    $this->getJson('/api/v1/tasks')->assertUnauthorized();
});

it('lists own tasks paginated', function (): void {
    $user = User::factory()->create();
    Task::factory()->for($user, 'user')->count(3)->create();
    Task::factory()->count(2)->create(); // other user

    Sanctum::actingAs($user);

    $this->getJson('/api/v1/tasks')
        ->assertOk()
        ->assertJsonStructure(['data', 'links', 'meta'])
        ->assertJsonCount(3, 'data');
});

it('creates task via api and dispatches event', function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    Event::fake();

    $this->postJson('/api/v1/tasks', [
        'title' => 'Nueva tarea API',
        'description' => 'Desde test',
        'status' => TaskStatus::Pending->value,
    ])->assertCreated()
        ->assertJsonPath('data.title', 'Nueva tarea API');

    expect(Task::query()->where('title', 'Nueva tarea API')->exists())->toBeTrue();

    Event::assertDispatched(TaskCreated::class);
});

it('validates store payload', function (): void {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $this->postJson('/api/v1/tasks', ['title' => ''])->assertUnprocessable()
        ->assertJsonValidationErrors(['title']);
});

it('shows own task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->for($user, 'user')->create();
    $other = User::factory()->create();
    $otherTask = Task::factory()->for($other, 'user')->create();

    Sanctum::actingAs($user);

    $this->getJson("/api/v1/tasks/{$task->id}")->assertOk()
        ->assertJsonPath('data.id', $task->id);

    $this->getJson("/api/v1/tasks/{$otherTask->id}")->assertForbidden();
});

it('updates own task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->for($user, 'user')->create(['title' => 'Old']);
    Sanctum::actingAs($user);

    Event::fake();

    $this->patchJson("/api/v1/tasks/{$task->id}", ['title' => 'Updated'])
        ->assertOk()
        ->assertJsonPath('data.title', 'Updated');

    Event::assertDispatched(TaskUpdated::class);
});

it('deletes own task', function (): void {
    $user = User::factory()->create();
    $task = Task::factory()->for($user, 'user')->create();
    Sanctum::actingAs($user);

    Event::fake();

    $this->deleteJson("/api/v1/tasks/{$task->id}")->assertNoContent();

    expect(Task::query()->find($task->id))->toBeNull();

    Event::assertDispatched(TaskDeleted::class);
});

it('enforces policy on delete other user task via api', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($owner, 'user')->create();
    Sanctum::actingAs($other);

    $this->deleteJson("/api/v1/tasks/{$task->id}")->assertForbidden();
});

it('filters tasks by status via api', function (): void {
    $user = User::factory()->create();
    Task::factory()->for($user, 'user')->create(['status' => TaskStatus::Done]);
    Task::factory()->for($user, 'user')->create(['status' => TaskStatus::Pending]);
    Sanctum::actingAs($user);

    $this->getJson('/api/v1/tasks?status=done')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.status', TaskStatus::Done->value);
});
