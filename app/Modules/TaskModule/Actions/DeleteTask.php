<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Actions;

use App\Modules\TaskModule\Models\Task;
use Illuminate\Support\Facades\DB;

final class DeleteTask
{
    public function handle(Task $task): void
    {
        DB::transaction(function () use ($task): void {
            $task->delete();
        });
    }

    public static function run(Task $task): void
    {
        app(self::class)->handle($task);
    }
}
