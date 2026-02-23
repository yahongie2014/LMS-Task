<?php

namespace App\Policies;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Enrollment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnrollmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $user->can('view_any_enrollment');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, Enrollment $enrollment): bool
    {
        return $user->can('view_enrollment');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return $user->can('create_enrollment');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Enrollment $enrollment): bool
    {
        return $user->can('update_enrollment');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Enrollment $enrollment): bool
    {
        return $user->can('delete_enrollment');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(Authenticatable $user): bool
    {
        return $user->can('delete_any_enrollment');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(Authenticatable $user, Enrollment $enrollment): bool
    {
        return $user->can('force_delete_enrollment');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(Authenticatable $user): bool
    {
        return $user->can('force_delete_any_enrollment');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(Authenticatable $user, Enrollment $enrollment): bool
    {
        return $user->can('restore_enrollment');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(Authenticatable $user): bool
    {
        return $user->can('restore_any_enrollment');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(Authenticatable $user, Enrollment $enrollment): bool
    {
        return $user->can('replicate_enrollment');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(Authenticatable $user): bool
    {
        return $user->can('reorder_enrollment');
    }
}
