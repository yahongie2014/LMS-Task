<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Instructor\StoreCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Instructor\UpdateCourseRequest;

class CourseController extends Controller
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $courses = $request->user()->courses()->latest()->paginate((int)$perPage);
        return $this->successResponse(CourseResource::collection($courses)->response()->getData(true));
    }

    public function store(StoreCourseRequest $request)
    {
        $course = $this->courseRepository->create($request->user()->id, $request->validated());

        return $this->successResponse(new CourseResource($course), __('messages.course_created'), 201);
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course = $this->courseRepository->update($course->id, $request->validated());

        return $this->successResponse(new CourseResource($course), __('messages.course_updated'));
    }
}
