<?php

namespace App\Providers;

use App\Events\CourseCompleted;
use App\Events\CourseEnrolled;
use App\Listeners\IssueCertificate;
use App\Listeners\SendCourseCompletionEmail;
use App\Listeners\SendEnrollmentEmail;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Registered::class, SendWelcomeEmail::class);
        Event::listen(CourseEnrolled::class, SendEnrollmentEmail::class);
        Event::listen(CourseCompleted::class, [
            SendCourseCompletionEmail::class,
            IssueCertificate::class,
        ]);

        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
