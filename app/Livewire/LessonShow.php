<?php

namespace App\Livewire;

use App\Actions\CompleteLesson;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\LessonCompletionRepositoryInterface;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LessonShow extends Component
{
    use AuthorizesRequests;

    public $course;
    public $lesson;
    public $isCompleted = false;
    public $isLocked = true;
    public $progress = 0;

    public function mount(
        $slug,
        $lesson,
        CourseRepositoryInterface $courseRepository,
        LessonRepositoryInterface $lessonRepository,
        LessonCompletionRepositoryInterface $lessonCompletionRepository
    ) {
        $this->course = $courseRepository->findBySlug($slug);
        $this->lesson = $lessonRepository->findByIdentifier($lesson, $this->course->id);

        $this->isLocked = !\Illuminate\Support\Facades\Gate::allows('view', $this->lesson) && !Auth::guard('instructor')->user()?->can('view', $this->lesson);

        if (Auth::check()) {
            $user = Auth::user();
            $this->isCompleted = $lessonCompletionRepository->isCompleted($user, $this->lesson);
            $this->progress = $lessonCompletionRepository->getCourseProgress($user, $this->course->id);
        }
    }

    public function markAsCompleted()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            app(CompleteLesson::class)->execute(Auth::user(), $this->lesson);
            $this->isCompleted = true;

            $lessonCompletionRepository = app(LessonCompletionRepositoryInterface::class);
            $this->progress = $lessonCompletionRepository->getCourseProgress(Auth::user(), $this->course->id);

            session()->flash('message', 'Lesson marked as completed!');
        } catch (\Throwable $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.lesson-show')
            ->layout('layouts.app', ['title' => $this->lesson->title]);
    }
}
