<?php

declare(strict_types=1);

namespace App\Modules\UserModule\Actions;

use App\Modules\UserModule\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Canonical way for other modules to fetch a User.
 *
 * Prefer this over direct DB queries to keep ownership in UserModule:
 *
 *   $user = FindUser::run($id);
 *   $user = FindUser::runOrFail($id);
 *   $user = FindUser::runOrNull($id);
 */
final class FindUser
{
    /**
     * Find user or throw ModelNotFoundException.
     */
    public function handle(int|string $id): User
    {
        /** @var User $user */
        $user = User::query()->findOrFail($id);

        return $user;
    }

    /**
     * Find user or return null.
     */
    public function handleOrNull(int|string $id): ?User
    {
        /** @var User|null $user */
        $user = User::query()->find($id);

        return $user;
    }

    /**
     * Static helper for inter-module calls: FindUser::run($id)
     *
     * @throws ModelNotFoundException
     */
    public static function run(int|string $id): User
    {
        return app(self::class)->handle($id);
    }

    public static function runOrNull(int|string $id): ?User
    {
        return app(self::class)->handleOrNull($id);
    }
}
