<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Listeners;

use App\Modules\TaskModule\Events\TaskCreated;
use App\Modules\TaskModule\Events\TaskDeleted;
use App\Modules\TaskModule\Events\TaskUpdated;
use Illuminate\Support\Facades\Log;

final class LogTaskActivity
{
    public function handle(TaskCreated|TaskUpdated|TaskDeleted $event): void
    {
        $context = match (true) {
            $event instanceof TaskCreated => ['event' => 'task.created', 'task_id' => $event->task->id, 'user_id' => $event->task->user_id],
            $event instanceof TaskUpdated => ['event' => 'task.updated', 'task_id' => $event->task->id, 'user_id' => $event->task->user_id],
            $event instanceof TaskDeleted => ['event' => 'task.deleted', 'task_id' => $event->taskId, 'user_id' => $event->userId],
        };

        Log::info('Task activity', $context);
    }
}
