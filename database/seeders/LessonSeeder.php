<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ---------------------------------------------------------
        // Laravel Mastery
        // ---------------------------------------------------------
        $course1 = Course::where('slug', 'laravel-mastery')->first();
        if ($course1) {
            Lesson::updateOrCreate(['course_id' => $course1->id, 'order_column' => 1], [
                'slug' => 'introduction-to-laravel',
                'title_en' => 'Introduction to Laravel',
                'title_ar' => 'مقدمة في لارافيل',
                'description_en' => 'What is Laravel and why use it? In this lesson, we will cover the core philosophy of the framework.',
                'description_ar' => 'ما هو لارافيل ولماذا نستخدمه؟ في هذا الدرس، سنغطي الفلسفة الأساسية لإطار العمل.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=QHef1hs64Wg',
                'duration' => 15,
                'is_preview' => true,
            ]);

            Lesson::updateOrCreate(['course_id' => $course1->id, 'order_column' => 2], [
                'slug' => 'routing-basics',
                'title_en' => 'Routing Basics',
                'title_ar' => 'أساسيات التوجيه',
                'description_en' => 'How to handle routes, parameters, and named routes in Laravel.',
                'description_ar' => 'كيفية التعامل مع المسارات والمعاملات والمسارات المسماة في لارافيل.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=1x-2frIm4tA',
                'duration' => 25,
                'is_preview' => false,
            ]);

            Lesson::updateOrCreate(['course_id' => $course1->id, 'order_column' => 3], [
                'slug' => 'eloquent-orm-foundations',
                'title_en' => 'Eloquent ORM Foundations',
                'title_ar' => 'أسس Eloquent ORM',
                'description_en' => 'Interacting with database records like a pro using Laravel’s expressive ORM.',
                'description_ar' => 'التفاعل مع سجلات قاعدة البيانات كالمحترفين باستخدام ORM التعبيري الخاص بـ لارافيل.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=6CDkBWnk5Uc',
                'duration' => 45,
                'is_preview' => false,
            ]);
        }

        // ---------------------------------------------------------
        // Advanced AI Engineering
        // ---------------------------------------------------------
        $course2 = Course::where('slug', 'advanced-ai')->first();
        if ($course2) {
            Lesson::updateOrCreate(['course_id' => $course2->id, 'order_column' => 1], [
                'slug' => 'transformer-architecture',
                'title_en' => 'Transformer Architecture',
                'title_ar' => 'بنية المحولات',
                'description_en' => 'Understanding the Attention mechanism and the architecture that changed AI.',
                'description_ar' => 'فهم آلية الانتباه والبنية التي غيرت الذكاء الاصطناعي.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=PA7imwsRGN0',
                'duration' => 30,
                'is_preview' => true,
            ]);

            Lesson::updateOrCreate(['course_id' => $course2->id, 'order_column' => 2], [
                'slug' => 'building-custom-llm-agents',
                'title_en' => 'Building Custom LLM Agents',
                'title_ar' => 'بناء وكلاء LLM مخصصين',
                'description_en' => 'How to build agents that can reason and use tools autonomously.',
                'description_ar' => 'كيفية بناء وكلاء يمكنهم التفكير واستخدام الأدوات بشكل مستقل.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=c_vZw06bkhQ',
                'duration' => 60,
                'is_preview' => false,
            ]);
        }

        // ---------------------------------------------------------
        // UX/UI Design Excellence
        // ---------------------------------------------------------
        $course3 = Course::where('slug', 'ui-ux-design')->first();
        if ($course3) {
            Lesson::updateOrCreate(['course_id' => $course3->id, 'order_column' => 1], [
                'slug' => 'visual-hierarchy-principles',
                'title_en' => 'Visual Hierarchy Principles',
                'title_ar' => 'مبادئ التسلسل الهرمي البصري',
                'description_en' => 'Mastering spacing, contrast, and typography to guide user attention.',
                'description_ar' => 'إتقان التباعد والتباين والخطوط لتوجيه انتباه المستخدم.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=5n7X2x96jUk&list=RD5n7X2x96jUk&start_radio=1&pp=oAcB0gcJCaIKAYcqIYzv',
                'duration' => 20,
                'is_preview' => true,
            ]);

            Lesson::updateOrCreate(['course_id' => $course3->id, 'order_column' => 2], [
                'slug' => 'prototyping-with-figma',
                'title_en' => 'Prototyping with Figma',
                'title_ar' => 'النماذج الأولية باستخدام فيغما',
                'description_en' => 'Translating static designs into interactive, testable prototypes.',
                'description_ar' => 'تحويل التصاميم الثابتة إلى نماذج أولية تفاعلية وقابلة للاختبار.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=Nd_UIKV2-zc',
                'duration' => 40,
                'is_preview' => false,
            ]);
        }

        // ---------------------------------------------------------
        // Mobile App Development with Flutter
        // ---------------------------------------------------------
        $course4 = Course::where('slug', 'flutter-development')->first();
        if ($course4) {
            Lesson::updateOrCreate(['course_id' => $course4->id, 'order_column' => 1], [
                'slug' => 'dart-language-fundamentals',
                'title_en' => 'Dart Language Fundamentals',
                'title_ar' => 'أساسيات لغة دارت',
                'description_en' => 'Everything you need to know about Dart before diving into Flutter.',
                'description_ar' => 'كل ما تحتاج لمعرفته حول لغة دارت قبل الغوص في فلاتر.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=tAvnl4_yVHQ',
                'duration' => 35,
                'is_preview' => true,
            ]);

            Lesson::updateOrCreate(['course_id' => $course4->id, 'order_column' => 2], [
                'slug' => 'creating-your-first-widget',
                'title_en' => 'Creating Your First Widget',
                'title_ar' => 'إنشاء عنصر واجهة المستخدم الأول الخاص بك',
                'description_en' => 'Understanding the "Everything is a Widget" philosophy.',
                'description_ar' => 'فهم فلسفة "كل شيء هو عنصر واجهة مستخدم".',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=BhMHFBsNHAk',
                'duration' => 25,
                'is_preview' => false,
            ]);
        }
    }
}
