<?php

namespace App\Actions;

use App\Models\Lesson;
use App\Models\User;
use App\Repositories\Interfaces\LessonCompletionRepositoryInterface;

class CompleteLesson
{
    protected $lessonCompletionRepository;

    public function __construct(LessonCompletionRepositoryInterface $lessonCompletionRepository)
    {
        $this->lessonCompletionRepository = $lessonCompletionRepository;
    }

    public function execute(User $user, Lesson $lesson): void
    {
        $this->lessonCompletionRepository->complete($user, $lesson);
    }
}
