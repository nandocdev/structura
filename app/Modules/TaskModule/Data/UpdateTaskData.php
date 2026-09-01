<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Data;

use App\Modules\TaskModule\Enums\TaskStatus;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

final class UpdateTaskData extends Data
{
    public function __construct(
        #[Max(255)]
        public ?string $title = null,

        #[Max(2000)]
        public ?string $description = null,

        public ?TaskStatus $status = null,
    ) {}
}
