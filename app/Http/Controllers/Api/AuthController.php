<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\SendOtpRequest;
use App\Http\Requests\Api\Auth\VerifyOtpRequest;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authRepository;
    protected $authService;

    public function __construct(AuthRepositoryInterface $authRepository, AuthService $authService)
    {
        $this->authRepository = $authRepository;
        $this->authService = $authService;
    }

    /**
     * Register a new user or instructor.
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->authRepository->register($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => $user->load('files'),
        ], __('Registration successful.'), 201);
    }

    /**
     * Login via email and password.
     */
    public function login(LoginRequest $request)
    {
        $model = $this->authRepository->findByEmail($request->email, $request->type);

        if (!$model || !Hash::check($request->password, $model->password)) {
            return $this->errorResponse(__('Invalid credentials.'), 401);
        }

        $token = $model->createToken($request->device_name)->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => $model,
        ], __('Login successful.'));
    }

    /**
     * Send OTP to user or instructor by phone number.
     */
    public function sendOtp(SendOtpRequest $request)
    {
        $model = $this->authRepository->findByPhone($request->phone, $request->type);

        if (!$model) {
            return $this->errorResponse(__('User not found with this phone number.'), 404);
        }

        $otpCode = $this->authService->generateOtp($request->phone, $model, false);

        return $this->successResponse([
            'otp' => config('app.debug') ? $otpCode : null,
        ], __('OTP sent successfully.'));
    }

    /**
     * Verify OTP and login.
     */
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $otp = $this->authService->verifyOtp($request->phone, $request->otp);

        if (!$otp) {
            return $this->errorResponse(__('Invalid or expired OTP.'), 401);
        }

        $model = $this->authRepository->findByPhone($request->phone, $request->type);

        if (!$model) {
            return $this->errorResponse(__('User not found.'), 404);
        }

        $token = $model->createToken($request->device_name)->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => $model,
            'is_new' => $otp->is_new,
        ], __('Login successful.'));
    }
}
