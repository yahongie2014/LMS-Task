<?php

namespace App\Policies;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $user->can('view_any_user');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function view(Authenticatable $user): bool
    {
        return $user->can('view_user');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function create(Authenticatable $user): bool
    {
        return $user->can('create_user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function update(Authenticatable $user): bool
    {
        return $user->can('update_user');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function delete(Authenticatable $user): bool
    {
        return $user->can('delete_user');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function deleteAny(Authenticatable $user): bool
    {
        return $user->can('delete_any_user');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function forceDelete(Authenticatable $user): bool
    {
        return $user->can('force_delete_user');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function forceDeleteAny(Authenticatable $user): bool
    {
        return $user->can('force_delete_any_user');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function restore(Authenticatable $user): bool
    {
        return $user->can('restore_user');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function restoreAny(Authenticatable $user): bool
    {
        return $user->can('restore_any_user');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function replicate(Authenticatable $user): bool
    {
        return $user->can('replicate_user');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  Authenticatable  $user
     * @return bool
     */
    public function reorder(Authenticatable $user): bool
    {
        return $user->can('reorder_user');
    }
}
