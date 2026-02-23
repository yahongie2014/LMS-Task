<?php

use App\Models\Instructor;
use App\Models\Course;

beforeEach(function () {
    $this->instructor = Instructor::factory()->create();
});

test('instructor can list their courses', function () {
    Course::factory()->count(3)->create(['instructor_id' => $this->instructor->id]);
    Course::factory()->create(); // Course from another instructor

    $response = $this->actingAs($this->instructor, 'instructor')
                     ->getJson('/api/instructor/courses');

    $response->assertStatus(200)
             ->assertJsonCount(3, 'data');
});

test('instructor can create a course', function () {
    $response = $this->actingAs($this->instructor, 'instructor')
                     ->postJson('/api/instructor/courses', [
                         'title_en' => 'New Course',
                         'title_ar' => 'دورة جديدة',
                         'description_en' => 'Course description',
                         'description_ar' => 'وصف الدورة',
                         'level' => 'beginner',
                         'price' => 100.00,
                         'duration' => 120,
                     ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('courses', [
        'instructor_id' => $this->instructor->id,
        'title_en' => 'New Course',
    ]);
});

test('instructor can update their course', function () {
    $course = Course::factory()->create(['instructor_id' => $this->instructor->id]);

    $response = $this->actingAs($this->instructor, 'instructor')
                     ->putJson("/api/instructor/courses/{$course->id}", [
                         'title_en' => 'Updated Title',
                         'price' => 150.00,
                     ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'title_en' => 'Updated Title',
        'price' => 150.00,
    ]);
});
