<?php

use App\Models\User;
use App\Models\Course;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;

beforeEach(function () {
    Mail::fake();
    Event::fake();
    $this->user = User::factory()->create();
    $this->user->wallet()->create(['balance' => 1000]);
});

test('student can get profile', function () {
    $response = $this->actingAs($this->user, 'sanctum')
                     ->getJson('/api/student/profile');

    $response->assertStatus(200)
             ->assertJsonPath('data.email', $this->user->email);
});

test('student can update profile', function () {
    $response = $this->actingAs($this->user, 'sanctum')
                     ->putJson('/api/student/profile', [
                         'name' => 'Updated Name',
                         'email' => 'updated@example.com',
                     ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);
});

test('student can enroll in a course', function () {
    $course = Course::factory()->create([
        'price' => 100,
        'is_published' => true,
    ]);

    $response = $this->actingAs($this->user, 'sanctum')
                     ->postJson('/api/student/enroll', [
                         'course_id' => $course->id,
                     ]);

    $response->assertStatus(200); // EnrollmentController returns 200 by default
    $this->assertDatabaseHas('enrollments', [
        'user_id' => $this->user->id,
        'course_id' => $course->id,
    ]);
    
    $this->assertEquals(900, $this->user->wallet->fresh()->balance);
});

test('student can not enroll with insufficient balance', function () {
    $this->user->wallet->update(['balance' => 50]);
    
    $course = Course::factory()->create([
        'price' => 100,
        'is_published' => true,
    ]);

    $response = $this->actingAs($this->user, 'sanctum')
                     ->postJson('/api/student/enroll', [
                         'course_id' => $course->id,
                     ]);

    $response->assertStatus(400)
             ->assertJson(['message' => 'Insufficient balance']);
});

test('student can deposit to wallet', function () {
    $response = $this->actingAs($this->user, 'sanctum')
                     ->postJson('/api/student/wallet/deposit', [
                         'amount' => 500,
                     ]);

    $response->assertStatus(200);
    $this->assertEquals(1500, $this->user->wallet->fresh()->balance);
});
