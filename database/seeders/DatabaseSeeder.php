<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles and Permissions first
        $this->call(RolesAndPermissionsSeeder::class);

        // 2. Admin Seeding
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@lms.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('super_admin');

        // 3. User Seeding
        $user = User::updateOrCreate(
            ['email' => 'student@lms.com'],
            [
                'name' => 'Demo Student',
                'email' => 'student@lms.com',
                'phone' => '01091950488',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole('student');
        $user->deposit(1000, 'Initial balance for testing');

        // 4. Content
        $this->call([
            InstructorSeeder::class,
            PlanSeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
            EnrollmentSeeder::class,
            CertificateSeeder::class,
            LessonCompletionSeeder::class,
        ]);
    }
}
