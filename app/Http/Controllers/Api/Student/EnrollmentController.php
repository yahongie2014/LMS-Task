<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Student\EnrollRequest;
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    use ApiResponse;

    private $enrollmentRepository;
    private $courseRepository;
    private $walletRepository;

    public function __construct(
        EnrollmentRepositoryInterface $enrollmentRepository,
        CourseRepositoryInterface $courseRepository,
        WalletRepositoryInterface $walletRepository
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->courseRepository = $courseRepository;
        $this->walletRepository = $walletRepository;
    }

    public function store(EnrollRequest $request)
    {
        $user = $request->user();
        $course = $this->courseRepository->findById($request->course_id);

        // Check if already enrolled
        if ($user->enrollments()->where('course_id', $course->id)->exists()) {
            return $this->errorResponse(__('messages.already_enrolled'), 400);
        }

        $wallet = $this->walletRepository->findByOwner($user);

        if ($wallet->balance < $course->price) {
            return $this->errorResponse(__('messages.insufficient_balance'), 400);
        }

        DB::transaction(function () use ($user, $course) {
            if ($course->price > 0) {
                $this->walletRepository->updateBalance(
                    $user,
                    $course->price,
                    'debit',
                    __('messages.course_enrollment') . ": {$course->title_en}"
                );
            }

            $this->enrollmentRepository->enroll($user, $course);
        });

        return $this->successResponse(null, __('messages.enrollment_success'));
    }
}
