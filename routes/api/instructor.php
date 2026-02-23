<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\Api\Instructor\AuthController::class, 'login']);

Route::middleware('auth:instructor')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Api\Instructor\ProfileController::class, 'show']);
    Route::get('/courses', [\App\Http\Controllers\Api\Instructor\CourseController::class, 'index']);
    Route::post('/courses', [\App\Http\Controllers\Api\Instructor\CourseController::class, 'store']);
    Route::put('/courses/{course}', [\App\Http\Controllers\Api\Instructor\CourseController::class, 'update']);
});
