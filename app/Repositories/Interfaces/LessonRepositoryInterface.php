<?php

namespace App\Repositories\Interfaces;

interface LessonRepositoryInterface
{
    public function findByIdentifier(int $id, int $courseId);
}
