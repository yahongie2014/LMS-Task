<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

test('users can only see course content if enrolled or preview', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    $course = Course::factory()->create();
    $lesson = Lesson::factory()->create(['course_id' => $course->id, 'is_preview' => false]);
    $previewLesson = Lesson::factory()->create(['course_id' => $course->id, 'is_preview' => true]);

    // Enroll user1
    $user1->enrollments()->create(['course_id' => $course->id]);

    // Test Gate checks
    // Assume we have a LessonPolicy with a view function
    $gate = app(\Illuminate\Contracts\Auth\Access\Gate::class);
    
    // User1 should be able to view the lesson
    expect($user1->can('view', $lesson))->toBeTrue();

    // User2 should NOT be able to view the lesson
    expect($user2->can('view', $lesson))->toBeFalse();

    // User2 CAN view preview lesson
    expect($user2->can('view', $previewLesson))->toBeTrue();
});
