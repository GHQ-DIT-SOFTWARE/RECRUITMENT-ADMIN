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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->unsignedBigInteger('card_id')->nullable();
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
            $table->string('cause_offers')->nullable();
            $table->string('applicant_image')->nullable();
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('other_names')->nullable();
            $table->string('sex')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('age')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->mediumText('residential_address')->nullable();
            $table->string('digital_address')->nullable();
            $table->mediumText('language')->nullable();
            $table->string('bece_index_number')->nullable();
            $table->date('bece_year_completion')->nullable();
            $table->string('bece_english')->nullable();
            $table->string('bece_mathematics')->nullable();
            $table->string('bece_subject_three')->nullable();
            $table->string('bece_subject_four')->nullable();
            $table->string('bece_subject_five')->nullable();
            $table->string('bece_subject_six')->nullable();
            $table->string('bece_subject_english_grade')->nullable();
            $table->string('bece_subject_maths_grade')->nullable();
            $table->string('bece_subject_three_grade')->nullable();
            $table->string('bece_subject_four_grade')->nullable();
            $table->string('bece_subject_five_grade')->nullable();
            $table->string('bece_subject_six_grade')->nullable();
            $table->mediumText('bece_certificate')->nullable();
            $table->string('secondary_course_offered')->nullable();
            $table->string('name_of_secondary_school')->nullable();
            $table->string('wassce_index_number')->nullable();
            $table->date('wassce_year_completion')->nullable();
            $table->string('wassce_serial_number')->nullable();
            $table->string('wassce_english')->nullable();
            $table->string('wassce_mathematics')->nullable();
            $table->string('wassce_subject_three')->nullable();
            $table->string('wassce_subject_four')->nullable();
            $table->string('wassce_subject_five')->nullable();
            $table->string('wassce_subject_six')->nullable();
            $table->string('wassce_subject_english_grade')->nullable();
            $table->string('wassce_subject_maths_grade')->nullable();
            $table->string('wassce_subject_three_grade')->nullable();
            $table->string('wassce_subject_four_grade')->nullable();
            $table->string('wassce_subject_five_grade')->nullable();
            $table->string('wassce_subject_six_grade')->nullable();
            $table->mediumText('wassce_certificate')->nullable();
            $table->string('qualification')->nullable();
            $table->text('exam_type_one')->nullable();
            $table->text('exam_type_two')->nullable();
            $table->text('exam_type_three')->nullable();
            $table->text('exam_type_four')->nullable();
            $table->text('exam_type_five')->nullable();
            $table->text('exam_type_six')->nullable();
            $table->text('results_slip_one')->nullable();
            $table->text('results_slip_two')->nullable();
            $table->text('results_slip_three')->nullable();
            $table->text('results_slip_four')->nullable();
            $table->text('results_slip_five')->nullable();
            $table->text('results_slip_six')->nullable();
            $table->mediumText('disqualification_reason')->nullable();
            $table->string('applicant_serial_number')->nullable();
            $table->string('national_identity_card')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('final_checked')->nullable()->comment('checked=1,unchecked=0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
