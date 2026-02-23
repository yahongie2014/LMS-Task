<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'instructor_id' => \App\Models\Instructor::factory(),
            'title_en' => $title,
            'title_ar' => $title . ' (AR)',
            'slug' => Str::slug($title) . '-' . uniqid(),
            'description_en' => $this->faker->paragraph,
            'description_ar' => $this->faker->paragraph . ' (AR)',
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'duration' => $this->faker->numberBetween(60, 600),
            'is_published' => true,
        ];
    }
}
