<?php

namespace App\Livewire;

use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use App\Repositories\Interfaces\LessonCompletionRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(
        EnrollmentRepositoryInterface $enrollmentRepository,
        LessonCompletionRepositoryInterface $lessonCompletionRepository
    ) {
        $user = Auth::user();
        
        $isInstructor = $user instanceof \App\Models\Instructor;

        if ($isInstructor) {
            $enrolledCourses = collect();
            $stats = [
                'enrolled_count' => 0,
                'completed_lessons' => 0,
                'certificates_count' => 0,
            ];
        } else {
            // Use repo to get enrolled courses. 
            $enrolledCourses = $user->enrollments()
                ->with(['course' => function($query) {
                    $query->withCount('lessons');
                }])
                ->get()
                ->map(function ($enrollment) use ($user, $lessonCompletionRepository) {
                    $course = $enrollment->course;
                    
                    $completedCount = $user->lessonCompletions()
                        ->where('course_id', $course->id)
                        ->whereNotNull('completed_at')
                        ->count();
                    
                    $progress = $lessonCompletionRepository->getCourseProgress($user, $course->id);
                    
                    $certificate = $user->certificates()->where('course_id', $course->id)->first();

                    return [
                        'id' => $course->id,
                        'title' => $course->title,
                        'slug' => $course->slug,
                        'image' => $course->image,
                        'description' => $course->description,
                        'progress' => $progress,
                        'completed_lessons' => $completedCount,
                        'total_lessons' => $course->lessons_count,
                        'enrolled_at' => $enrollment->enrolled_at,
                        'certificate' => $certificate,
                    ];
                });

            $stats = [
                'enrolled_count' => $enrolledCourses->count(),
                'completed_lessons' => $user->lessonCompletions()->whereNotNull('completed_at')->count(),
                'certificates_count' => $user->certificates()->count(),
            ];
        }

        return view('livewire.dashboard', [
            'enrolledCourses' => $enrolledCourses,
            'stats' => $stats,
        ])->layout('layouts.app', ['title' => __('messages.dashboard')]);
    }
}
