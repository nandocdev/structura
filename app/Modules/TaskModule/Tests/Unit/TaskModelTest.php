<?php

declare(strict_types=1);

use App\Modules\TaskModule\Enums\TaskStatus;
use App\Modules\TaskModule\Models\Task;
use Tests\TestCase;

uses(TestCase::class);

it('casts status to enum and exposes helper', function (): void {
    $task = Task::factory()->make(['user_id' => 1, 'status' => TaskStatus::Done]);

    expect($task->status)->toBeInstanceOf(TaskStatus::class)
        ->and($task->isDone())->toBeTrue();
});

it('has correct fillable', function (): void {
    $task = new Task;

    expect($task->getFillable())->toEqualCanonicalizing(['user_id', 'title', 'description', 'status']);
});
