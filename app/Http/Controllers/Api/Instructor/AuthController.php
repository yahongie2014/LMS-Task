<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $instructorRepository;

    public function __construct(\App\Repositories\Interfaces\InstructorRepositoryInterface $instructorRepository)
    {
        $this->instructorRepository = $instructorRepository;
    }

    public function login(\App\Http\Requests\Api\Instructor\LoginRequest $request)
    {
        $instructor = $this->instructorRepository->findByEmail($request->email);

        if (!$instructor || !\Illuminate\Support\Facades\Hash::check($request->password, $instructor->password)) {
            return $this->errorResponse(__('messages.invalid_credentials'), 401);
        }

        return $this->successResponse([
            'token' => $instructor->createToken('instructor-token')->plainTextToken,
            'instructor' => new \App\Http\Resources\InstructorResource($instructor)
        ], __('messages.login_success'));
    }
}
