<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Student\WalletController;
use App\Http\Controllers\Api\Student\PlanController;
use App\Http\Controllers\Api\Student\SubscriptionController;
use App\Http\Controllers\Api\Student\EnrollmentController;


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

    Route::get('/wallet', [WalletController::class, 'index']);
    Route::post('/wallet/deposit', [WalletController::class, 'deposit']);
    Route::get('/plans', [PlanController::class, 'index']);
    Route::post('/subscribe', [SubscriptionController::class, 'store']);

    Route::post('/enroll', [EnrollmentController::class, 'store']);
});
