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
        Schema::create('body_selections', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->string('body_selection_status')->nullable();
            $table->mediumText('body_selection_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_selections');
    }
};
