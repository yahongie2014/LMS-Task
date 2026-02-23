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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('otp');
            $table->nullableMorphs('customable'); // customable_id & customable_type
            $table->boolean('is_new')->default(false);
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');

        Schema::table('users', function (Blueprint $table) {
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
        });

        Schema::table('instructors', function (Blueprint $table) {
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
        });
    }
};
