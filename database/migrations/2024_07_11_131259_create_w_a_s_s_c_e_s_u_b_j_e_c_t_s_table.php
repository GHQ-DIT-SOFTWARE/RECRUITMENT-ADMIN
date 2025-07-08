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
        Schema::create('w_a_s_s_c_e_s_u_b_j_e_c_t_s', function (Blueprint $table) {
            $table->id();
             $table->uuid()->index();
             $table->string('wasscesubjects')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('w_a_s_s_c_e_s_u_b_j_e_c_t_s');
    }
};
