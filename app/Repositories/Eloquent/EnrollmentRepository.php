<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Models\User;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use App\Events\CourseEnrolled;
use Illuminate\Support\Facades\DB;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function isEnrolled(User $user, Course $course): bool
    {
        return $user->enrollments()->where('course_id', $course->id)->exists();
    }

    public function enroll(User $user, Course $course): void
    {
        if (!$course->is_published) {
            throw new \Exception('Cannot enroll in a draft course.');
        }

        if ($this->isEnrolled($user, $course)) {
            return; // Idempotent
        }

        DB::transaction(function () use ($user, $course) {
            $user->enrollments()->create([
                'course_id' => $course->id,
            ]);
        });

        event(new CourseEnrolled($user, $course));
    }
}
