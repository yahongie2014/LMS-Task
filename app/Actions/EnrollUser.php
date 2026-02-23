<?php

namespace App\Actions;

use App\Models\Course;
use App\Models\User;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;

class EnrollUser
{
    protected $enrollmentRepository;

    public function __construct(EnrollmentRepositoryInterface $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function execute(User $user, Course $course): void
    {
        $this->enrollmentRepository->enroll($user, $course);
    }
}
