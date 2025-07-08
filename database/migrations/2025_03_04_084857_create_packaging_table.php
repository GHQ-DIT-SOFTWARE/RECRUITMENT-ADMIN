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
        Schema::create('packaging', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('user_id');
            $table->string('course_id');
            $table->string('level');
            $table->string('semester');
            $table->string('category_id');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packaging');
    }
};
