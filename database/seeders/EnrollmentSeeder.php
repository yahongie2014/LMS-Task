<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'student@lms.com')->first();
        $course = Course::where('slug', 'laravel-mastery')->first();

        if ($user && $course) {
            Enrollment::updateOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['enrolled_at' => now()]
            );
        }
    }
}
