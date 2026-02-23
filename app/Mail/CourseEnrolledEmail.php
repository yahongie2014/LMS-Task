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

class CourseEnrolledEmail extends Mailable
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
            subject: 'You have enrolled in ' . ($this->course->title_en ?? $this->course->title),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.course-enrolled',
            with: [
                'name' => $this->user->name,
                'courseTitle' => $this->course->title_en ?? $this->course->title,
            ],
        );
    }
}
