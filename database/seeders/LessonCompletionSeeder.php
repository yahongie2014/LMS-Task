<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\User;
use Illuminate\Database\Seeder;

class LessonCompletionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'student@lms.com')->first();
        $lesson = Lesson::where('slug', 'introduction-to-laravel')->first();

        if ($user && $lesson) {
            LessonCompletion::updateOrCreate(
                ['user_id' => $user->id, 'lesson_id' => $lesson->id],
                [
                    'course_id' => $lesson->course_id,
                    'completed_at' => now()
                ]
            );
        }
    }
}
