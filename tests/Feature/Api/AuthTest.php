<?php

use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;

test('new users can register as student', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Student User',
        'email' => 'student@example.com',
        'phone' => '01091950488',
        'password' => 'password',
        'password_confirmation' => 'password',
        'type' => 'user',
    ]);

    $response->assertStatus(201)
             ->assertJsonStructure([
                 'status',
                 'message',
                 'data' => [
                     'token',
                     'user'
                 ]
             ]);

    $this->assertDatabaseHas('users', [
        'email' => 'student@example.com',
    ]);
});

test('new users can register as instructor', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Instructor User',
        'email' => 'instructor@example.com',
        'phone' => '01091950488',
        'password' => 'password',
        'password_confirmation' => 'password',
        'type' => 'instructor',
    ]);

    $response->assertStatus(201)
             ->assertJsonStructure([
                 'status',
                 'message',
                 'data' => [
                     'token',
                     'user'
                 ]
             ]);

    $this->assertDatabaseHas('instructors', [
        'email' => 'instructor@example.com',
    ]);
});

test('users can login', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password',
        'type' => 'user',
        'device_name' => 'test-device',
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'status',
                 'data' => [
                     'token',
                     'user'
                 ]
             ]);
});

test('instructors can login', function () {
    Instructor::factory()->create([
        'email' => 'inst@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'inst@example.com',
        'password' => 'password',
        'type' => 'instructor',
        'device_name' => 'test-device',
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'status',
                 'data' => [
                     'token',
                     'user'
                 ]
             ]);
});

test('otp can be sent', function () {
    $user = User::factory()->create([
        'phone' => '01091950488',
    ]);

    $response = $this->postJson('/api/auth/send-otp', [
        'phone' => '01091950488',
        'type' => 'user',
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'status' => 'success',
                 'message' => 'OTP sent successfully.'
             ]);
});

test('otp can be verified', function () {
    $user = User::factory()->create([
        'phone' => '01091950488',
    ]);

    \App\Models\Otp::create([
        'phone' => '01091950488',
        'otp' => '123456',
        'customable_id' => $user->id,
        'customable_type' => get_class($user),
        'expires_at' => now()->addMinutes(10),
    ]);

    $response = $this->postJson('/api/auth/verify-otp', [
        'phone' => '01091950488',
        'otp' => '123456',
        'type' => 'user',
        'device_name' => 'test-device',
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'status',
                 'data' => [
                     'token',
                     'user',
                     'is_new'
                 ]
             ]);
});
