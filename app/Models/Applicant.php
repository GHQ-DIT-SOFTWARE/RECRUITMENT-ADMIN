<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Notifications\Notifiable;

class Applicant extends Model implements Auditable
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;
    use \OwenIt\Auditing\Auditable;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'card_id',

        'course',
        'qualification',
        'applicant_image',
        'surname',
        'first_name',
        'other_names',
        'sex',
        'marital_status',
        'date_of_birth',
        'contact',
        'email',
        'residential_address',
        'language',
        'sports_interest',
        'secondary_course_offered',
        'name_of_secondary_school',
        'wassce_index_number',
        'wassce_year_completion',
        'wassce_serial_number',
        'wassce_english',
        'wassce_mathematics',
        'wassce_subject_three',
        'wassce_subject_four',
        'wassce_subject_five',
        'wassce_subject_six',
        'wassce_subject_english_grade',
        'wassce_subject_maths_grade',
        'wassce_subject_three_grade',
        'wassce_subject_four_grade',
        'wassce_subject_five_grade',
        'wassce_subject_six_grade',
        'wassce_certificate',
        'cause_offers',
        'final_checked',
        'pin_number',
        'professional_programme',
        'national_identity_card',
        'digital_address',
        'exam_type_one',
        'exam_type_two',
        'exam_type_three',
        'exam_type_four',
        'exam_type_five',
        'exam_type_six',
        'results_slip_one',
        'results_slip_two',
        'results_slip_three',
        'results_slip_four',
        'results_slip_five',
        'results_slip_six',
        'age',
        'disqualification_reason',
        'applicant_serial_number',
        'disability_status',
        'disability_reason',
        'identity_type',
        'national_identity_card',
        'duplicate_entry'
    ];
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
    public function districts()
    {
        return $this->belongsTo(District::class, 'district', 'id');
    }

    public function regions()
    {
        return $this->belongsTo(Region::class, 'region', 'id');
    }

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course', 'id');
    }
    public function resultVerification()
    {
        return $this->hasOne(ResultVerification::class, 'applicant_id', 'id');
    }

    protected $appends = [];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function documentation_phase()
    {
        return $this->hasOne(Documentation::class);
    }

    public function aptitude_phase()
    {
        return $this->hasOne(Aptitude::class);
    }


    public function interview_phase()
    {
        return $this->hasOne(Interview::class);
    }

    protected $casts = [
        'language' => 'array',
        'sports_interest' => 'array',
    ];
}
