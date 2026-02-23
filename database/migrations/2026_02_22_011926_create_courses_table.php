<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title_en');
            $table->string('title_ar')->nullable();
            $table->string('slug');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration')->nullable(); // minutes
            $table->string('level')->default('beginner'); // beginner, intermediate, advanced
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['slug', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
