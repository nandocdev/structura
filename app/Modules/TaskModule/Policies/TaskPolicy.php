<?php

declare(strict_types=1);

namespace App\Modules\TaskModule\Policies;

use App\Modules\TaskModule\Models\Task;
use App\Modules\UserModule\Models\User;
use Illuminate\Auth\Access\Response;

final class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id || $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool|Response
    {
        if ($user->id === $task->user_id) {
            return true;
        }

        return $user->hasRole('admin')
            ? true
            : Response::deny('No puedes editar tareas de otro usuario.');
    }

    public function delete(User $user, Task $task): bool|Response
    {
        if ($user->id === $task->user_id) {
            return true;
        }

        return $user->hasRole('admin')
            ? true
            : Response::deny('No puedes eliminar tareas de otro usuario.');
    }
}
