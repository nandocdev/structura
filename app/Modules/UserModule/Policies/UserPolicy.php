<?php

declare(strict_types=1);

namespace App\Modules\UserModule\Policies;

use App\Modules\UserModule\Models\User;
use Illuminate\Auth\Access\Response;

final class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, User $targetUser): bool|Response
    {
        if ($authUser->id === $targetUser->id) {
            return true;
        }

        return $authUser->hasRole('admin')
            ? true
            : Response::deny('No autorizado para ver este usuario.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authUser): bool
    {
        return $authUser->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $targetUser): bool|Response
    {
        if ($authUser->id === $targetUser->id) {
            return true;
        }

        return $authUser->hasRole('admin')
            ? true
            : Response::deny('No autorizado para actualizar este usuario.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $targetUser): bool|Response
    {
        // No auto-borrado; solo admin y nunca a sí mismo
        if ($authUser->id === $targetUser->id) {
            return Response::deny('No puedes eliminar tu propia cuenta por esta vía.');
        }

        return $authUser->hasRole('admin')
            ? true
            : Response::deny('No autorizado para eliminar usuarios.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $authUser, User $targetUser): bool
    {
        return $authUser->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $authUser, User $targetUser): bool
    {
        return $authUser->hasRole('admin');
    }
}
