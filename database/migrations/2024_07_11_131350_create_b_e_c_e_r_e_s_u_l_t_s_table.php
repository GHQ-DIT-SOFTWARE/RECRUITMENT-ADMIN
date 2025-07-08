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
        Schema::create('b_e_c_e_r_e_s_u_l_t_s', function (Blueprint $table) {
            $table->id();
             $table->uuid()->index();
             $table->string('beceresults')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_e_c_e_r_e_s_u_l_t_s');
    }
};
