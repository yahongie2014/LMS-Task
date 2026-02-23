<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{
    public function getPublishedCourses(int $perPage = 10)
    {
        return Course::with('instructor')->where('is_published', true)->paginate($perPage);
    }

    public function findBySlug(string $slug)
    {
        return Course::with(['instructor', 'lessons' => function ($q) {
            $q->orderBy('order_column');
        }])->where('slug', $slug)->firstOrFail();
    }

    public function findById(int $id)
    {
        return Course::findOrFail($id);
    }

    public function create(int $instructorId, array $data)
    {
        return Course::create(array_merge($data, [
            'instructor_id' => $instructorId,
            'slug' => \Illuminate\Support\Str::slug($data['title_en'] ?? 'course') . '-' . uniqid(),
        ]));
    }

    public function update(int $courseId, array $data)
    {
        $course = $this->findById($courseId);
        $course->update($data);
        return $course;
    }
}
