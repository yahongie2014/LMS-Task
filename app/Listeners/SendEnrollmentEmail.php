<?php

namespace App\Listeners;

use App\Events\CourseEnrolled;
use App\Mail\CourseEnrolledEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEnrollmentEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(CourseEnrolled $event): void
    {
        Mail::to($event->user)->send(new CourseEnrolledEmail($event->user, $event->course));
        Log::info("Enrollment email queued for user {$event->user->id} for course {$event->course->id}");
    }
}
