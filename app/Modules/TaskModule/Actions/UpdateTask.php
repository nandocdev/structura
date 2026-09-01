<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Actions;

use App\Modules\TaskModule\Data\UpdateTaskData;
use App\Modules\TaskModule\Events\TaskUpdated;
use App\Modules\TaskModule\Models\Task;
use Illuminate\Support\Facades\DB;

final class UpdateTask
{
    public function handle(Task $task, UpdateTaskData $data): Task
    {
        $task = DB::transaction(function () use ($task, $data): Task {
            $payload = array_filter([
                'title' => $data->title,
                'description' => $data->description,
                'status' => $data->status,
            ], fn (mixed $v): bool => $v !== null);

            if ($payload !== []) {
                $task->update($payload);
            }

            return $task->refresh();
        });

        TaskUpdated::dispatch($task);

        return $task;
    }

    public static function run(Task $task, UpdateTaskData $data): Task
    {
        return app(self::class)->handle($task, $data);
    }
}
