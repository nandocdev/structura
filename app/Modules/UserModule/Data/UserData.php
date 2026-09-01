<?php

declare(strict_types=1);

namespace App\Modules\UserModule\Data;

use App\Modules\UserModule\Models\User;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;

final class UserData extends Data
{
    public function __construct(
        #[Max(255)]
        public string $name,

        #[Max(255), Email]
        public string $email,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            name: $user->name,
            email: $user->email,
        );
    }
}
