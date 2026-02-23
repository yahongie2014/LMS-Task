<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::updateOrCreate(
            ['slug' => 'basic-plan'],
            [
                'name_en' => 'Basic Plan',
                'name_ar' => 'الخطة الأساسية',
                'description_en' => 'Access to all courses for 1 month.',
                'description_ar' => 'الوصول إلى جميع الدورات لمدة شهر واحد.',
                'price' => 19.99,
                'duration_months' => 1,
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['slug' => 'premium-plan'],
            [
                'name_en' => 'Premium Plan',
                'name_ar' => 'الخطة المميزة',
                'description_en' => 'Access to all courses and certificates for 6 months.',
                'description_ar' => 'الوصول إلى جميع الدورات والشهادات لمدة 6 أشهر.',
                'price' => 99.99,
                'duration_months' => 6,
                'is_active' => true,
            ]
        );

        Plan::updateOrCreate(
            ['slug' => 'ultimate-plan'],
            [
                'name_en' => 'Ultimate Plan',
                'name_ar' => 'الخطة النهائية',
                'description_en' => 'Lifetime access to all current and future courses.',
                'description_ar' => 'وصول مدى الحياة لجميع الدورات الحالية والمستقبلية.',
                'price' => 299.99,
                'duration_months' => 120, // 10 years
                'is_active' => true,
            ]
        );
    }
}
