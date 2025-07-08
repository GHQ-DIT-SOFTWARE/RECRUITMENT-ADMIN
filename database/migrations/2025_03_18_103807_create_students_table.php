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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('index_number')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('offering_courses')->onDelete('cascade');
            $table->string('applicant_image')->nullable();
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('other_names')->nullable();
            $table->string('sex')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->mediumText('residential_address')->nullable();
            $table->string('digital_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
