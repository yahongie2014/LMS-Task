<?php

use App\Http\Controllers\Api\Instructor\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Instructor\AuthController;
use App\Http\Controllers\Api\Instructor\CourseController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:instructor')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{course}', [CourseController::class, 'update']);
});
