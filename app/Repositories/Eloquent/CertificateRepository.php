<?php

namespace App\Repositories\Eloquent;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use App\Repositories\Interfaces\CertificateRepositoryInterface;

class CertificateRepository implements CertificateRepositoryInterface
{
    public function hasCompletedCourse(User $user, Course $course): bool
    {
        $totalLessons = $course->lessons()->count();
        $completedLessons = $user->lessonCompletions()
            ->where('course_id', $course->id)
            ->whereNotNull('completed_at')
            ->count();

        return $totalLessons > 0 && $completedLessons >= $totalLessons;
    }

    public function findById(string $id): Certificate
    {
        return Certificate::with(['user', 'course'])->findOrFail($id);
    }

    public function firstOrNew(User $user, Course $course): Certificate
    {
        return Certificate::firstOrNew([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    public function generate(User $user, Course $course): Certificate
    {
        return Certificate::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    public function getUserCertificates(User $user, int $perPage = 10)
    {
        return $user->certificates()->with(['course', 'user'])->paginate($perPage);
    }
}
