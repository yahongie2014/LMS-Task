<?php

namespace App\Repositories\Eloquent;

use App\Models\Lesson;
use App\Repositories\Interfaces\LessonRepositoryInterface;

class LessonRepository implements LessonRepositoryInterface
{
    public function findByIdentifier(int $id, int $courseId)
    {
        return Lesson::with('course')->where('id', $id)->where('course_id', $courseId)->firstOrFail();
    }
}
