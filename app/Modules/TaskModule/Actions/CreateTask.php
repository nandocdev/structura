<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Actions;

use App\Modules\TaskModule\Data\CreateTaskData;
use App\Modules\TaskModule\Events\TaskCreated;
use App\Modules\TaskModule\Models\Task;
use App\Modules\UserModule\Models\User;
use Illuminate\Support\Facades\DB;

final class CreateTask
{
    public function handle(User $owner, CreateTaskData $data): Task
    {
        $task = DB::transaction(function () use ($owner, $data): Task {
            /** @var Task $task */
            $task = Task::query()->create([
                'user_id' => $owner->id,
                'title' => $data->title,
                'description' => $data->description,
                'status' => $data->status,
            ]);

            return $task;
        });

        TaskCreated::dispatch($task);

        return $task;
    }

    public static function run(User $owner, CreateTaskData $data): Task
    {
        return app(self::class)->handle($owner, $data);
    }
}
