<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

// OTP Authentication
Route::post('/auth/send-otp', [\App\Http\Controllers\Api\AuthController::class, 'sendOtp']);
Route::post('/auth/verify-otp', [\App\Http\Controllers\Api\AuthController::class, 'verifyOtp']);


// Student Routes
Route::prefix('student')->group(base_path('routes/api/student.php'));

// Instructor Routes
Route::prefix('instructor')->group(base_path('routes/api/instructor.php'));

// Common/Legacy Routes (Optional: if you want to keep existing ones working)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Api\ProfileController::class, 'show']);
});
