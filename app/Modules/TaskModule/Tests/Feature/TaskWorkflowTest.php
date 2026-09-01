<?php

declare(strict_types=1);

use App\Modules\TaskModule\Actions\CreateTask;
use App\Modules\TaskModule\Actions\DeleteTask;
use App\Modules\TaskModule\Actions\UpdateTask;
use App\Modules\TaskModule\Data\CreateTaskData;
use App\Modules\TaskModule\Data\UpdateTaskData;
use App\Modules\TaskModule\Enums\TaskStatus;
use App\Modules\TaskModule\Models\Task;
use App\Modules\UserModule\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('creates a task via action', function (): void {
    $user = User::factory()->create();

    $task = CreateTask::run($user, new CreateTaskData(
        title: 'Preparar reporte',
        description: 'Reporte semanal',
        status: TaskStatus::Pending,
    ));

    expect($task->title)->toBe('Preparar reporte')
        ->and($task->user_id)->toBe($user->id)
        ->and($task->status)->toBe(TaskStatus::Pending);
});

it('updates a task via action', function (): void {
    $task = Task::factory()->create(['title' => 'Old']);

    $updated = UpdateTask::run($task, new UpdateTaskData(
        title: 'New title',
        status: TaskStatus::Done,
    ));

    expect($updated->title)->toBe('New title')
        ->and($updated->status)->toBe(TaskStatus::Done);
});

it('deletes a task via action', function (): void {
    $task = Task::factory()->create();

    DeleteTask::run($task);

    expect(Task::query()->find($task->id))->toBeNull();
});

it('scopes tasks for user and pending', function (): void {
    $user = User::factory()->create();
    Task::factory()->for($user, 'user')->create(['status' => TaskStatus::Pending]);
    Task::factory()->for($user, 'user')->create(['status' => TaskStatus::Done]);
    Task::factory()->create(['status' => TaskStatus::Pending]);

    $pendingForUser = Task::query()->forUser($user->id)->pending()->get();

    expect($pendingForUser)->toHaveCount(1);
});

it('enforces task policy for update', function (): void {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($owner, 'user')->create();

    expect($other->can('update', $task))->toBeFalse()
        ->and($owner->can('update', $task))->toBeTrue();
});

it('authenticated user can view tasks page', function (): void {
    $user = User::factory()->create();
    $user->email_verified_at = now();
    $user->save();

    $this->actingAs($user)->get(route('tasks.index'))->assertOk();
});
