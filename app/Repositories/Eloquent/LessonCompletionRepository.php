<?php

namespace App\Repositories\Eloquent;

use App\Events\CourseCompleted;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\User;
use App\Repositories\Interfaces\LessonCompletionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LessonCompletionRepository implements LessonCompletionRepositoryInterface
{
    public function isCompleted(User $user, Lesson $lesson): bool
    {
        return $user->lessonCompletions()
            ->where('lesson_id', $lesson->id)
            ->whereNotNull('completed_at')
            ->exists();
    }

    public function getCourseProgress(User $user, int $courseId): int
    {
        $course = Course::withCount('lessons')->find($courseId);

        if (!$course || $course->lessons_count === 0) {
            return 0;
        }

        $completedCount = $user->lessonCompletions()
            ->where('course_id', $courseId)
            ->whereNotNull('completed_at')
            ->count();

        return (int) round(($completedCount / $course->lessons_count) * 100);
    }

    public function complete(User $user, Lesson $lesson): void
    {
        if (!$user->enrollments()->where('course_id', $lesson->course_id)->exists()) {
            throw new \Exception('Not enrolled in this course.');
        }

        if ($this->isCompleted($user, $lesson)) {
            return; // Idempotent
        }

        DB::transaction(function () use ($user, $lesson) {
            $completion = LessonCompletion::firstOrCreate(
                ['user_id' => $user->id, 'lesson_id' => $lesson->id, 'course_id' => $lesson->course_id],
                ['started_at' => now()]
            );

            $completion->update(['completed_at' => now()]);

            $this->checkCourseCompletion($user, $lesson->course_id);
        });
    }

    protected function checkCourseCompletion(User $user, int $courseId): void
    {
        $course = Course::withCount('lessons')->find($courseId);

        if (!$course || $course->lessons_count === 0) {
            return;
        }

        $completedCount = $user->lessonCompletions()
            ->where('course_id', $courseId)
            ->whereNotNull('completed_at')
            ->count();

        if ($completedCount >= $course->lessons_count) {
            if (!$user->certificates()->where('course_id', $courseId)->exists()) {
                CourseCompleted::dispatch($user, $course);
            }
        }
    }
}
