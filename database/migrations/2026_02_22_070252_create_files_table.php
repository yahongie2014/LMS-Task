<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('fileable_type');
            $table->unsignedBigInteger('fileable_id');
            $table->string('file_type', 20)->nullable();
            $table->string('file_size', 20)->nullable();
            $table->string('folder')->nullable();
            $table->string('label')->nullable();
            $table->string('notes')->nullable();
            $table->tinyInteger('order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['fileable_type', 'fileable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
