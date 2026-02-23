<?php

namespace App\Repositories\Interfaces;

use App\Models\Course;
use App\Models\User;
use App\Models\Certificate;

interface CertificateRepositoryInterface
{
    /**
     * Check if a user has completed a specific course.
     */
    public function hasCompletedCourse(User $user, Course $course): bool;

    /**
     * Find a certificate by its ID.
     */
    public function findById(string $id): Certificate;

    /**
     * Get or instantiate a certificate instance without saving.
     */
    public function firstOrNew(User $user, Course $course): Certificate;

    /**
     * Get or create a certificate instance and save it.
     */
    public function generate(User $user, Course $course): Certificate;

    public function getUserCertificates(\App\Models\User $user, int $perPage = 10);
}
