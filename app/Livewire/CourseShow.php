<?php

namespace App\Livewire;

use App\Actions\EnrollUser;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CourseShow extends Component
{
    public $course;
    public $isEnrolled = false;

    public function mount($slug, CourseRepositoryInterface $courseRepository, EnrollmentRepositoryInterface $enrollmentRepository)
    {
        $this->course = $courseRepository->findBySlug($slug);

        if (Auth::check()) {
            $this->isEnrolled = $enrollmentRepository->isEnrolled(Auth::user(), $this->course);
        }
    }

    public function enroll()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            app(EnrollUser::class)->execute(Auth::user(), $this->course);
            $this->isEnrolled = true;
            session()->flash('message', 'Successfully enrolled in course!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.course-show')
            ->layout('layouts.app', ['title' => $this->course->title]);
    }
}
