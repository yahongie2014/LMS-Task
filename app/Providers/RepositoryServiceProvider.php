<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Eloquent\CourseRepository;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Repositories\Eloquent\LessonRepository;
use App\Repositories\Interfaces\CertificateRepositoryInterface;
use App\Repositories\Eloquent\CertificateRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Eloquent\ProfileRepository;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use App\Repositories\Eloquent\EnrollmentRepository;
use App\Repositories\Interfaces\LessonCompletionRepositoryInterface;
use App\Repositories\Eloquent\LessonCompletionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(LessonRepositoryInterface::class, LessonRepository::class);
        $this->app->bind(CertificateRepositoryInterface::class, CertificateRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(EnrollmentRepositoryInterface::class, EnrollmentRepository::class);
        $this->app->bind(LessonCompletionRepositoryInterface::class, LessonCompletionRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\InstructorRepositoryInterface::class, \App\Repositories\Eloquent\EloquentInstructorRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\PlanRepositoryInterface::class, \App\Repositories\Eloquent\EloquentPlanRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\WalletRepositoryInterface::class, \App\Repositories\Eloquent\EloquentWalletRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\SubscriptionRepositoryInterface::class, \App\Repositories\Eloquent\SubscriptionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
