<?php

namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface
{
    public function getPublishedCourses(int $perPage = 10);
    public function findBySlug(string $slug);
    public function findById(int $id);
    public function create(int $instructorId, array $data);
    public function update(int $courseId, array $data);
}
