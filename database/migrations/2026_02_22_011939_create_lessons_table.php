<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title_en');
            $table->string('title_ar')->nullable();
            $table->string('slug')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('video_type')->default('plyr'); // youtube, custom, plyr
            $table->string('video_url')->nullable(); // Plyr ID or URL
            $table->integer('duration')->nullable(); // minutes
            $table->integer('order_column')->default(0);
            $table->boolean('is_preview')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
