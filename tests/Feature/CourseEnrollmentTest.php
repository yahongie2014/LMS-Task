<?php

use App\Actions\EnrollUser;
use App\Models\Course;
use App\Models\User;

test('enrollment integrity idempotency', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();

    $action = app(EnrollUser::class);
    
    // First enrollment
    $action->execute($user, $course);
    expect($user->enrollments()->count())->toBe(1);

    // Second enrollment attempt
    $action->execute($user, $course);
    expect($user->enrollments()->count())->toBe(1); // Should not duplicate
});

test('cannot enroll in draft courses', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create(['is_published' => false]);

    $action = app(EnrollUser::class);
    
    $action->execute($user, $course);
})->throws(Exception::class, 'Cannot enroll in a draft course');
