<?php

namespace App\Policies;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Lesson;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $user->can('view_any_lesson');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Authenticatable $user, Lesson $lesson): bool
    {
        // Allow if lesson is a preview (even for guests)
        if ($lesson->is_preview) {
            return true;
        }

        // Must be logged in for non-preview lessons
        if (!$user) {
            return false;
        }

        // Allow if user has the explicit permission (e.g., admin)
        if ($user->can('view_lesson')) {
            return true;
        }

        // Allow if user is enrolled in the course
        return $user->enrollments()->where('course_id', $lesson->course_id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return $user->can('create_lesson');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Lesson $lesson): bool
    {
        return $user->can('update_lesson');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Lesson $lesson): bool
    {
        return $user->can('delete_lesson');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(Authenticatable $user): bool
    {
        return $user->can('delete_any_lesson');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(Authenticatable $user, Lesson $lesson): bool
    {
        return $user->can('force_delete_lesson');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(Authenticatable $user): bool
    {
        return $user->can('force_delete_any_lesson');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(Authenticatable $user, Lesson $lesson): bool
    {
        return $user->can('restore_lesson');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(Authenticatable $user): bool
    {
        return $user->can('restore_any_lesson');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(Authenticatable $user, Lesson $lesson): bool
    {
        return $user->can('replicate_lesson');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(Authenticatable $user): bool
    {
        return $user->can('reorder_lesson');
    }
}
