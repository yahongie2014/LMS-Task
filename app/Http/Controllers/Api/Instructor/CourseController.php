<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    protected $courseRepository;

    public function __construct(\App\Repositories\Interfaces\CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $courses = $request->user()->courses()->latest()->paginate((int)$perPage);
        return $this->successResponse(\App\Http\Resources\CourseResource::collection($courses)->response()->getData(true));
    }

    public function store(\App\Http\Requests\Api\Instructor\StoreCourseRequest $request)
    {
        $course = $this->courseRepository->create($request->user()->id, $request->validated());

        return $this->successResponse(new \App\Http\Resources\CourseResource($course), __('messages.course_created'), 201);
    }

    public function update(\App\Http\Requests\Api\Instructor\UpdateCourseRequest $request, Course $course)
    {
        $course = $this->courseRepository->update($course->id, $request->validated());

        return $this->successResponse(new \App\Http\Resources\CourseResource($course), __('messages.course_updated'));
    }
}
