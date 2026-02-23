<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    private $lessonRepository;

    public function __construct(LessonRepositoryInterface $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    public function show($courseId, $id)
    {
        $lesson = $this->lessonRepository->findByIdentifier($id, $courseId);
        return $this->successResponse(new LessonResource($lesson));
    }
}
