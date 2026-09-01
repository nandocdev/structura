<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Listeners;

use App\Modules\TaskModule\Events\TaskCreated;
use App\Modules\TaskModule\Events\TaskDeleted;
use App\Modules\TaskModule\Events\TaskUpdated;
use App\Modules\TaskModule\Jobs\ProcessTaskMetricsJob;
use Illuminate\Contracts\Queue\ShouldQueue;

final class QueueTaskMetrics implements ShouldQueue
{
    public function handle(TaskCreated|TaskUpdated|TaskDeleted $event): void
    {
        $payload = match (true) {
            $event instanceof TaskCreated => ['event' => 'created', 'id' => $event->task->id, 'user' => $event->task->user_id],
            $event instanceof TaskUpdated => ['event' => 'updated', 'id' => $event->task->id, 'user' => $event->task->user_id],
            $event instanceof TaskDeleted => ['event' => 'deleted', 'id' => $event->taskId, 'user' => $event->userId],
        };

        ProcessTaskMetricsJob::dispatch($payload['event'], $payload['id'], $payload['user'])
            ->onQueue('metrics');
    }
}
