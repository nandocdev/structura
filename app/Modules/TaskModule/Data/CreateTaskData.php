<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Data;

use App\Modules\TaskModule\Enums\TaskStatus;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

final class CreateTaskData extends Data
{
    public function __construct(
        #[Required, Max(255)]
        public string $title,

        #[Max(2000)]
        public ?string $description = null,

        public TaskStatus $status = TaskStatus::Pending,
    ) {}
}
