<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseCompletedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $course;

    public function __construct(User $user, Course $course)
    {
        $this->user = $user;
        $this->course = $course;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Congratulations on completing ' . $this->course->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.course-completed',
            with: [
                'name' => $this->user->name,
                'course' => $this->course->title,
            ],
        );
    }
}
