<?php

use App\Models\Course;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

test('slug uniqueness ignores soft deleted courses', function () {
    $course1 = Course::factory()->create(['slug' => 'test-slug']);
    $course1->delete(); // Soft delete

    // Attempt to validate a new course with the same slug
    $data = ['slug' => 'test-slug'];
    
    $validator = Validator::make($data, [
        'slug' => [
            'required',
            Rule::unique('courses', 'slug')->whereNull('deleted_at'),
        ]
    ]);

    expect($validator->passes())->toBeTrue();
});

test('slug uniqueness blocks active duplicate', function () {
    Course::factory()->create(['slug' => 'test-slug']);

    // Attempt to validate a new course with the same slug
    $data = ['slug' => 'test-slug'];
    
    $validator = Validator::make($data, [
        'slug' => [
            'required',
            Rule::unique('courses', 'slug')->whereNull('deleted_at'),
        ]
    ]);

    expect($validator->passes())->toBeFalse();
});
