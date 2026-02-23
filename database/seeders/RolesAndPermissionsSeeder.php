<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ---------------------------------------------------------
        // ADMIN GUARD PERMISSIONS & ROLES
        // ---------------------------------------------------------
        $adminPermissions = [
            // Courses
            'view_any_course', 'view_course', 'create_course', 'update_course', 'delete_course', 'delete_any_course',
            // Lessons
            'view_any_lesson', 'view_lesson', 'create_lesson', 'update_lesson', 'delete_lesson', 'delete_any_lesson',
            // Certificates
            'view_any_certificate', 'view_certificate', 'create_certificate', 'update_certificate', 'delete_certificate', 'delete_any_certificate',
            // Users
            'view_any_user', 'view_user', 'create_user', 'update_user', 'delete_user', 'delete_any_user',
            // Enrollments
            'view_any_enrollment', 'view_enrollment', 'create_enrollment', 'update_enrollment', 'delete_enrollment', 'delete_any_enrollment',
            // Roles/Permissions
            'view_any_role', 'view_role', 'create_role', 'update_role', 'delete_role', 'delete_any_role',
            // General management
            'manage_settings', 'view_analytics',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::findOrCreate($permission, 'admin');
        }

        // Super Admin gets everything
        $superAdmin = Role::findOrCreate('super_admin', 'admin');
        $superAdmin->syncPermissions(Permission::where('guard_name', 'admin')->get());

        // Content Manager
        $contentManager = Role::findOrCreate('content_manager', 'admin');
        $contentManager->syncPermissions([
            'view_any_course', 'view_course', 'create_course', 'update_course',
            'view_any_lesson', 'view_lesson', 'create_lesson', 'update_lesson',
        ]);

        // ---------------------------------------------------------
        // WEB GUARD PERMISSIONS & ROLES
        // ---------------------------------------------------------
        $webPermissions = [
            'enroll courses',
            'view courses',
            'complete lessons',
            'download certificates',
        ];

        foreach ($webPermissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $student = Role::findOrCreate('student', 'web');
        $student->syncPermissions([
            'enroll courses',
            'view courses',
            'complete lessons',
        ]);
    }
}
