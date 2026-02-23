<?php

namespace App\Repositories\Interfaces;

use App\Models\Course;
use App\Models\User;

interface EnrollmentRepositoryInterface
{
    /**
     * Check if a user is enrolled in a course.
     */
    public function isEnrolled(User $user, Course $course): bool;

    /**
     * Enroll a user in a course.
     */
    public function enroll(User $user, Course $course): void;
}
