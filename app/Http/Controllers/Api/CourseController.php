<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $courses = $this->courseRepository->getPublishedCourses((int)$perPage);
        return $this->successResponse(CourseResource::collection($courses)->response()->getData(true));
    }

    public function show($slug)
    {
        $course = $this->courseRepository->findBySlug($slug);
        
        $course->load('lessons'); 
        return $this->successResponse(new CourseResource($course));
    }
}
