<?php

namespace App\Livewire;

use App\Repositories\Interfaces\CourseRepositoryInterface;
use Livewire\Component;

class CourseIndex extends Component
{
    public function render(CourseRepositoryInterface $courseRepository)
    {
        $courses = $courseRepository->getPublishedCourses();
            
        return view('livewire.course-index', [
            'courses' => $courses
        ])->layout('layouts.app', ['title' => __('messages.courses')]);
    }
}
