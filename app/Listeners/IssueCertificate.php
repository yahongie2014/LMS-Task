<?php

namespace App\Listeners;

use App\Events\CourseCompleted;
use App\Repositories\Interfaces\CertificateRepositoryInterface;
use Illuminate\Support\Facades\Log;

class IssueCertificate
{
    protected $certificateRepository;

    public function __construct(CertificateRepositoryInterface $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    public function handle(CourseCompleted $event): void
    {
        $user = $event->user;
        $course = $event->course;

        // Use repo to generate (handles idempotency inside)
        try {
            $certificate = $this->certificateRepository->generate($user, $course);
            Log::info("Certificate issued for user {$user->id} on course {$course->id} (ID: {$certificate->id})");
        } catch (\Exception $e) {
            Log::error("Failed to issue certificate for user {$user->id} on course {$course->id}: " . $e->getMessage());
        }
    }
}
