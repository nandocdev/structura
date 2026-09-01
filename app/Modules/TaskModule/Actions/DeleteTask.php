<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Actions;

use App\Modules\TaskModule\Events\TaskDeleted;
use App\Modules\TaskModule\Models\Task;
use Illuminate\Support\Facades\DB;

final class DeleteTask
{
    public function handle(Task $task): void
    {
        $taskId = $task->id;
        $userId = $task->user_id;

        DB::transaction(function () use ($task): void {
            $task->delete();
        });

        TaskDeleted::dispatch($taskId, $userId);
    }

    public static function run(Task $task): void
    {
        app(self::class)->handle($task);
    }
}
