<?php

use App\Actions\CompleteLesson;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Events\CourseCompleted;
use App\Listeners\IssueCertificate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Mail\CourseCompletedEmail;
use Illuminate\Support\Facades\Mail;

test('completing all lessons triggers course completed event once', function () {
    Event::fake();

    $user = User::factory()->create();
    $course = Course::factory()->create();
    $lesson1 = Lesson::factory()->create(['course_id' => $course->id]);
    $lesson2 = Lesson::factory()->create(['course_id' => $course->id]);

    $user->enrollments()->create(['course_id' => $course->id]);

    // Use app() to resolve dependencies
    $action = app(CompleteLesson::class);

    // Complete lesson 1
    $action->execute($user, $lesson1);
    Event::assertNotDispatched(CourseCompleted::class);

    // Complete lesson 2
    $action->execute($user, $lesson2);
    Event::assertDispatched(CourseCompleted::class, 1);
    
    // Complete lesson 2 again (repeat action)
    $action->execute($user, $lesson2);
    Event::assertDispatched(CourseCompleted::class, 1);
});

test('issue certificate listener creates certificate and ensures idempotency', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();

    $event = new CourseCompleted($user, $course);
    
    // Use app() to resolve dependencies
    $listener = app(IssueCertificate::class);

    // Handle course completed
    $listener->handle($event);
    expect($user->certificates()->count())->toBe(1);

    // Call listener multiple times
    $listener->handle($event);
    $listener->handle($event);

    expect($user->certificates()->count())->toBe(1);
});
