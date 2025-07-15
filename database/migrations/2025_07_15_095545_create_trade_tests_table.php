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
        Schema::create('trade_tests', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->string('trade_test_status')->nullable();
            $table->mediumText('trade_test_marks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_tests');
    }
};
