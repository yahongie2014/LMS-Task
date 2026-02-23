<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// OTP Authentication
Route::post('/auth/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOtp']);


// Student Routes
Route::prefix('student')->group(base_path('routes/api/student.php'));

// Instructor Routes
Route::prefix('instructor')->group(base_path('routes/api/instructor.php'));

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
});
