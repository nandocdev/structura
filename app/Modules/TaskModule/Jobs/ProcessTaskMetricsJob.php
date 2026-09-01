<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Laravel\Pulse\Facades\Pulse;

final class ProcessTaskMetricsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly string $event,
        public readonly int $taskId,
        public readonly int $userId,
    ) {}

    public function handle(): void
    {
        // Contador en cache (observabilidad simple, sin DB)
        $key = "metrics:tasks:{$this->event}";
        Cache::increment($key);

        // Pulse — ignora si no está habilitado
        try {
            Pulse::record('task_events', $this->event)->count()->maxNorm(100);
        } catch (\Throwable) {
            // Pulse deshabilitado en tests o sin Redis
        }
    }
}
