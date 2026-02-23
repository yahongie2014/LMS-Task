<?php

namespace App\Repositories\Interfaces;

use App\Models\Lesson;
use App\Models\User;

interface LessonCompletionRepositoryInterface
{
    /**
     * Check if a user has completed a specific lesson.
     */
    public function isCompleted(User $user, Lesson $lesson): bool;

    /**
     * Calculate the user's progress in a course.
     */
    public function getCourseProgress(User $user, int $courseId): int;

    /**
     * Mark a lesson as completed for a user.
     */
    public function complete(User $user, Lesson $lesson): void;
}
