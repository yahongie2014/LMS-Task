<?php

namespace App\Listeners;

use App\Events\CourseCompleted;
use App\Mail\CourseCompletedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCourseCompletionEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(CourseCompleted $event): void
    {
        Mail::to($event->user)->send(new CourseCompletedEmail($event->user, $event->course));
        Log::info("Course completion email queued for user {$event->user->id}");
    }
}
