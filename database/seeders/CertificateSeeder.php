<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'student@lms.com')->first();
        $course = Course::where('slug', 'ui-ux-design')->first();

        if ($user && $course) {
            Certificate::updateOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['issued_at' => now()]
            );
        }
    }
}
