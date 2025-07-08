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
        Schema::create('sub_branches', function (Blueprint $table) {
            $table->id();
             $table->uuid()->index();
              $table->unsignedBigInteger('branch_id')->nullable();
             $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
             $table->string('sub_branch')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_branches');
    }
};
