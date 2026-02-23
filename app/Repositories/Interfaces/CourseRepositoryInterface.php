<?php

namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface
{
    public const DEFAULT_PAGINATE = 10;

    public function getPublishedCourses(int $perPage = self::DEFAULT_PAGINATE);
    public function findBySlug(string $slug);
    public function findById(int $id);
    public function create(int $instructorId, array $data);
    public function update(int $courseId, array $data);
}
