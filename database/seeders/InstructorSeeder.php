<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Instructor::updateOrCreate(
            ['email' => 'instructor@lms.com'],
            [
                'name' => 'John Doe',
                'phone' => '01091950488',
                'password' => Hash::make('12345678'),
                'bio' => 'Expert in web development and AI.',
                'specialty' => 'Full Stack & AI',
            ]
        );

        Instructor::updateOrCreate(
            ['email' => 'jane@lms.com'],
            [
                'name' => 'Jane Smith',
                'phone' => '01011299488',
                'password' => Hash::make('12345678'),
                'bio' => 'UX/UI designer with 10 years experience.',
                'specialty' => 'UX/UI Design',
            ]
        );
    }
}
