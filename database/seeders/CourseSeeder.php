<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor1 = \App\Models\Instructor::where('email', 'instructor@lms.com')->first();
        $instructor2 = \App\Models\Instructor::where('email', 'jane@lms.com')->first();

        // Course 1: Laravel Mastery
        Course::updateOrCreate(
            ['slug' => 'laravel-mastery'],
            [
                'instructor_id' => $instructor1?->id,
                'title_en' => 'Laravel Mastery',
                'title_ar' => 'احتراف لارافيل',
                'description_en' => 'Learn Laravel from scratch to advanced level. Build scalable, real-world applications.',
                'description_ar' => 'تعلم لارافيل من الصفر حتى الاحتراف. قم ببناء تطبيقات قابلة للتوسع في العالم الحقيقي.',
                'level' => 'intermediate',
                'price' => 49.99,
                'duration' => 120,
                'is_published' => true,
                'image' => 'https://cdn.hdwebsoft.com/wp-content/uploads/2021/11/Thiet-ke-chua-co-ten-4.jpg.webp',
            ]
        );

        // Course 2: Advanced AI Engineering
        Course::updateOrCreate(
            ['slug' => 'advanced-ai'],
            [
                'instructor_id' => $instructor1?->id,
                'title_en' => 'Advanced AI Engineering',
                'title_ar' => 'هندسة الذكاء الاصطناعي المتقدمة',
                'description_en' => 'Deep dive into LLMs, generative agents, and transformer neural networks.',
                'description_ar' => 'غوص عميق في النماذج اللغوية الكبيرة والوكلاء التوليديين والشبكات العصبية التحويلية.',
                'level' => 'advanced',
                'price' => 199.99,
                'duration' => 450,
                'is_published' => true,
                'image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&q=80&w=2070',
            ]
        );

        // Course 3: UX/UI Design Excellence
        Course::updateOrCreate(
            ['slug' => 'ui-ux-design'],
            [
                'instructor_id' => $instructor2?->id,
                'title_en' => 'UX/UI Design Excellence',
                'title_ar' => 'التميز في تصميم تجربة المستخدم وواجهته',
                'description_en' => 'Master the art of creating stunning, user-centric digital experiences.',
                'description_ar' => 'أتقن فن إنشاء تجارب رقمية مذهلة تتمحور حول المستخدم.',
                'level' => 'beginner',
                'price' => 29.50,
                'duration' => 300,
                'is_published' => true,
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&q=80&w=2000',
            ]
        );

        // Course 4: Mobile App Development with Flutter
        Course::updateOrCreate(
            ['slug' => 'flutter-development'],
            [
                'instructor_id' => $instructor1?->id,
                'title_en' => 'Mobile App Development with Flutter',
                'title_ar' => 'تطوير تطبيقات الجوال باستخدام فلاتر',
                'description_en' => 'Build high-performance cross-platform iOS and Android apps with a single codebase.',
                'description_ar' => 'قم ببناء تطبيقات iOS وأندرويد عالية الأداء ومتعددة المنصات باستخدام قاعدة كود واحدة.',
                'level' => 'intermediate',
                'price' => 75.00,
                'duration' => 600,
                'is_published' => true,
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&q=80&w=2070',
            ]
        );
    }
}
