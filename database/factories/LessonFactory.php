<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title_en' => $this->faker->sentence,
            'title_ar' => 'عنوان - ' . $this->faker->sentence,
            'description_en' => $this->faker->paragraph,
            'description_ar' => 'وصف - ' . $this->faker->paragraph,
            'slug' => $this->faker->slug,
            'video_url' => 'https://vimeo.com/12345',
            'order_column' => $this->faker->numberBetween(1, 100),
            'is_preview' => false,
        ];
    }
}
