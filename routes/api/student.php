<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\ProfileController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{slug}', [CourseController::class, 'show']);
    Route::get('/courses/{courseId}/lessons/{id}', [LessonController::class, 'show']);
    
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'password']);
    
    Route::get('/certificates', [CertificateController::class, 'index']);
    Route::get('/certificates/{id}', [CertificateController::class, 'show']);
    Route::get('/courses/{course}/certificate-preview', [CertificateController::class, 'preview']);
    Route::post('/courses/{course}/certificate-generate', [CertificateController::class, 'generate']);
    
    // Wallet & Plans
    Route::get('/wallet', [\App\Http\Controllers\Api\Student\WalletController::class, 'index']);
    Route::post('/wallet/deposit', [\App\Http\Controllers\Api\Student\WalletController::class, 'deposit']);
    Route::get('/plans', [\App\Http\Controllers\Api\Student\PlanController::class, 'index']);
    Route::post('/subscribe', [\App\Http\Controllers\Api\Student\SubscriptionController::class, 'store']);

    // Enrollments
    Route::post('/enroll', [\App\Http\Controllers\Api\Student\EnrollmentController::class, 'store']);
});
