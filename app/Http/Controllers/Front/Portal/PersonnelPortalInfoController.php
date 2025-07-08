<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Portal;

use App\Http\Controllers\Controller;
use App\Models\AgeLimit;
use App\Models\Applicant;
use App\Models\BECERESULTS;
use App\Models\BECESUBJECT;
use App\Models\Branch;
use App\Models\Card;
use App\Models\Course;
use App\Models\District;
use App\Models\Region;
use App\Models\WASSCERESULTS;
use App\Models\WASSCESUBJECT;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Image;

class PersonnelPortalInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('portal');
    }

    public function index()
    {

        $ghanaian_languages = [
            'ENGLISH', 'FRENCH', 'RUSSIA', 'CHINESE', 'AKUAPEM TWI', 'DAGBANI', 'EWE', 'GA', 'DAGOMBA', 'DANGME', 'FANTE', 'KASEM',
            'NZEMA', 'KUSAAL', 'ASANTE TWI', 'FRAFRA', 'BULI', 'KROBO', 'GRUSI', 'GUANG',
            'HAUSA', 'KUSAAL', 'SISAALA', 'NCHUMBURUNG', 'DAGAARE', 'DANGME', 'DWABENG',
            'FANTE', 'GONJA', 'KASEM', 'NZEMA', 'SAFALIBA', 'SISALA', 'TWI', 'UNGANA',
            'WALI', 'BOMU', 'GURENNE', 'JWIRA-PEPESA', 'KANTOSI', 'KONKOMBA', 'KUSASI',
            'MOORE', 'NABA', 'WASA',
        ];

        $sports_interests = [
            'FOOTBALL', 'BASKETBALL', 'TENNIS', 'SWIMMING', 'ATHLETICS', 'BADMINTON', 'GOLF',
            'CRICKET', 'TABLE TENNIS', 'VOLLEYBALL', 'BOXING', 'CYCLING', 'MARTIAL ARTS',
            'HIKING', 'SKIING', 'SNOWBOARDING', 'SURFING', 'SKATEBOARDING', 'DANCING',
        ];
        $serial_number = session('serial_number');
        $pincode = session('pincode');
        $card = Card::where('serial_number', $serial_number)->where('pincode', $pincode)->first();
        $applied_applicant = Applicant::with('districts', 'regions')->where('card_id', $card->id)->first();
        $districts = District::all();
        $regions = Region::all();
        $bece_results = BECERESULTS::all();
        $bece_subject = BECESUBJECT::all();
        $wassce_results = WASSCERESULTS::all();
        $wassce_subject = WASSCESUBJECT::all();
        return view('portal.apply', compact('wassce_subject', 'wassce_results', 'bece_subject', 'bece_results', 'districts', 'regions', 'applied_applicant', 'ghanaian_languages', 'sports_interests'));
    }
    public function biodata()
    {
        $ghanaian_languages = [
            'ENGLISH', 'FRENCH', 'RUSSIA', 'CHINESE', 'AKUAPEM TWI', 'DAGBANI', 'EWE', 'GA', 'DAGOMBA', 'DANGME', 'FANTE', 'KASEM',
            'NZEMA', 'KUSAAL', 'ASANTE TWI', 'FRAFRA', 'BULI', 'KROBO', 'GRUSI', 'GUANG',
            'HAUSA', 'KUSAAL', 'SISAALA', 'NCHUMBURUNG', 'DAGAARE', 'DANGME', 'DWABENG',
            'FANTE', 'GONJA', 'KASEM', 'NZEMA', 'SAFALIBA', 'SISALA', 'TWI', 'UNGANA',
            'WALI', 'BOMU', 'GURENNE', 'JWIRA-PEPESA', 'KANTOSI', 'KONKOMBA', 'KUSASI',
            'MOORE', 'NABA', 'WASA',
        ];

        $sports_interests = [
            'FOOTBALL', 'BASKETBALL', 'TENNIS', 'SWIMMING', 'ATHLETICS', 'BADMINTON', 'GOLF',
            'CRICKET', 'TABLE TENNIS', 'VOLLEYBALL', 'BOXING', 'CYCLING', 'MARTIAL ARTS',
            'HIKING', 'SKIING', 'SNOWBOARDING', 'SURFING', 'SKATEBOARDING', 'DANCING',
        ];
        $serial_number = session('serial_number');
        $pincode = session('pincode');
        $card = Card::where('serial_number', $serial_number)->where('pincode', $pincode)->first();
        $applied_applicant = Applicant::with('districts', 'regions')->where('card_id', $card->id)->first();
        $districts = District::all();
        $regions = Region::all();
        return view('portal.biodata', compact('districts', 'regions', 'applied_applicant', 'ghanaian_languages', 'sports_interests'));
    }
    public function education_details()
    {
        $serial_number = session('serial_number');
        $pincode = session('pincode');
        $card = Card::where('serial_number', $serial_number)->where('pincode', $pincode)->first();
        $applied_applicant = Applicant::with('districts', 'regions')->where('card_id', $card->id)->first();
        $bece_results = BECERESULTS::all();
        $bece_subject = BECESUBJECT::all();
        $wassce_results = WASSCERESULTS::all();
        $wassce_subject = WASSCESUBJECT::all();
        return view('portal.education', compact('wassce_subject', 'wassce_results', 'bece_subject', 'bece_results', 'applied_applicant', ));
    }
    public function Profession_details()
    {
        $serial_number = session('serial_number');
        $pincode = session('pincode');
        $card = Card::where('serial_number', $serial_number)->where('pincode', $pincode)->first();
        $applied_applicant = Applicant::with('districts', 'regions')->where('card_id', $card->id)->first();
        return view('portal.profession', compact('applied_applicant'));
    }
    public function preview()
    {
        $serial_number = session('serial_number');
        $pincode = session('pincode');
        $card = Card::where('serial_number', $serial_number)->where('pincode', $pincode)->first();
        $applied_applicant = Applicant::with('districts', 'regions')->where('card_id', $card->id)->first();
        return view('portal.preview', compact('applied_applicant'));
    }
    public function saveBioData(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'applicant_image' => 'nullable|image|mimes:jpg,png|max:2048',
            'surname' => 'required',
            'othernames' => 'nullable|string',
            'sex' => 'required',
            'marital_status' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required|date',
            'hometown' => 'required',
            'district' => 'required',
            'region' => 'required',
            'contact' => 'required',
            'email' => 'required|email',
            'employment' => 'required',
            'residential_address' => 'required',
            'language' => 'required|array',
            'sports_interest' => 'required|array',
        ]);

        $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
        $save_url = $applicant->applicant_image;
        if ($request->hasFile('applicant_image')) {
            $image = $request->file('applicant_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('uploads/applicantimages/' . $name_gen);
            $save_url = 'uploads/applicantimages/' . $name_gen;
        }
        $applicant->update([
            'applicant_image' => $save_url,
            'branch' => $request->branch,
            'course' => $request->course,
            'surname' => $request->surname,
            'other_names' => $request->other_names,
            'sex' => $request->sex,
            'marital_status' => $request->marital_status,
            'height' => $request->height,
            'weight' => $request->weight,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'hometown' => $request->hometown,
            'district' => $request->district,
            'region' => $request->region,
            'contact' => $request->contact,
            'email' => $request->email,
            'employment' => $request->employment,
            'residential_address' => $request->residential_address,
            'national_identity_card' => $request->national_identity_card,
            'digital_address' => $request->digital_address,
            'language' => json_encode($request->language), // Save as JSON
            'sports_interest' => json_encode($request->sports_interest), // Save as JSON
        ]);
        // Redirect to the next step
        return redirect()->route('education-details');
    }
    
    public function saveEducationData(Request $request)
    {
        $request->validate([
            'bece_english' => 'required',
            'bece_mathematics' => 'required',
            'bece_subject_three' => 'required|different:bece_subject_four,bece_subject_five,bece_subject_six',
            'bece_subject_four' => 'required|different:bece_subject_three,bece_subject_five,bece_subject_six',
            'bece_subject_five' => 'required|different:bece_subject_three,bece_subject_four,bece_subject_six',
            'bece_subject_six' => 'required|different:bece_subject_three,bece_subject_four,bece_subject_five',
            'wassce_english' => 'required',
            'wassce_mathematics' => 'required',
            'wassce_subject_three' => 'required|different:wassce_subject_four,wassce_subject_five,wassce_subject_six',
            'wassce_subject_four' => 'required|different:wassce_subject_three,wassce_subject_five,wassce_subject_six',
            'wassce_subject_five' => 'required|different:wassce_subject_three,wassce_subject_four,wassce_subject_six',
            'wassce_subject_six' => 'required|different:wassce_subject_three,wassce_subject_four,wassce_subject_five',
            'bece_certificate' => 'nullable|file|mimes:pdf|max:1024',
            'wassce_certificate' => 'nullable|file|mimes:pdf|max:1024',
            'degree_certificate' => 'nullable|file|mimes:pdf|max:1024',
        ]);
        $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
        $bece_save_url = $applicant->bece_certificate;
        if ($request->hasFile('bece_certificate')) {
            $file = $request->file('bece_certificate');
            $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/jhscertficate'), $name_gen);
            $bece_save_url = 'uploads/jhscertficate/' . $name_gen;
        }
        $wassce_save_url = $applicant->wassce_certificate;
        if ($request->hasFile('wassce_certificate')) {
            $file = $request->file('wassce_certificate');
            $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/shscertificate'), $name_gen);
            $wassce_save_url = 'uploads/shscertificate/' . $name_gen;
        }
        $degree_save_url = $applicant->degree_certificate;
        if ($request->hasFile('degree_certificate')) {
            $file = $request->file('degree_certificate');
            $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/degreecertificate'), $name_gen);
            $degree_save_url = 'uploads/degreecertificate/' . $name_gen;
        }

        $applicant->update([
            'bece_index_number' => $request->bece_index_number,
            'bece_year_completion' => $request->bece_year_completion,
            'wassce_index_number' => $request->wassce_index_number,
            'wassce_year_completion' => $request->wassce_year_completion,
            'wassce_serial_number' => $request->wassce_serial_number,
            'secondary_course_offered' => $request->secondary_course_offered,
            'name_of_secondary_school' => $request->name_of_secondary_school,
            'bece_certificate' => $bece_save_url,
            // BECE grades
            'bece_english' => $request->bece_english,
            'bece_subject_english_grade' => $request->bece_subject_english_grade,
            'bece_mathematics' => $request->bece_mathematics,
            'bece_subject_maths_grade' => $request->bece_subject_maths_grade,
            'bece_subject_three' => $request->bece_subject_three,
            'bece_subject_three_grade' => $request->bece_subject_three_grade,
            'bece_subject_four' => $request->bece_subject_four,
            'bece_subject_four_grade' => $request->bece_subject_four_grade,
            'bece_subject_five' => $request->bece_subject_five,
            'bece_subject_five_grade' => $request->bece_subject_five_grade,
            'bece_subject_six' => $request->bece_subject_six,
            'bece_subject_six_grade' => $request->bece_subject_six_grade,
            // WASSCE grades
            'wassce_english' => $request->wassce_english,
            'wassce_subject_english_grade' => $request->wassce_subject_english_grade,
            'wassce_mathematics' => $request->wassce_mathematics,
            'wassce_subject_maths_grade' => $request->wassce_subject_maths_grade,
            'wassce_subject_three' => $request->wassce_subject_three,
            'wassce_subject_three_grade' => $request->wassce_subject_three_grade,
            'wassce_subject_four' => $request->wassce_subject_four,
            'wassce_subject_four_grade' => $request->wassce_subject_four_grade,
            'wassce_subject_five' => $request->wassce_subject_five,
            'wassce_subject_five_grade' => $request->wassce_subject_five_grade,
            'wassce_subject_six' => $request->wassce_subject_six,
            'wassce_subject_six_grade' => $request->wassce_subject_six_grade,
            'wassce_certificate' => $wassce_save_url,
            // Tertiary education details
            'name_of_tertiary' => $request->name_of_tertiary,
            'tertiary_qualification' => $request->tertiary_qualification,
            'programme' => $request->programme,
            'year_of_completion' => $request->year_of_completion,
            'class_attained' => $request->class_attained,
            'degree_certificate' => $degree_save_url,
            //
            'exam_type_one' => $request->exam_type_one,
            'exam_type_two' => $request->exam_type_two,
            'exam_type_three' => $request->exam_type_three,
            'exam_type_four' => $request->exam_type_four,
            'exam_type_five' => $request->exam_type_five,
            'exam_type_six' => $request->exam_type_six,
            'results_slip_one' => $request->results_slip_one,
            'results_slip_two' => $request->results_slip_two,
            'results_slip_three' => $request->results_slip_three,
            'results_slip_four' => $request->results_slip_four,
            'results_slip_five' => $request->results_slip_five,
            'results_slip_six' => $request->results_slip_six,
        ]);
        return redirect()->route('Profession-details');
    }

    public function saveProfessionalData(Request $request)
    {
        $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
        $save_url = $applicant->professional_certificate;
        if ($request->hasFile('professional_certificate')) {
            $file = $request->file('professional_certificate');
            $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/professionalcertificate'), $name_gen);
            $save_url = 'uploads/professionalcertificate/' . $name_gen;
        }
        $applicant->update([
            'name_of_professional_school' => $request->name_of_professional_school,
            'professional_programme' => $request->professional_programme,
            'professional_qualification' => $request->professional_qualification,
            'year_of_professional_completion' => $request->year_of_professional_completion,
            'year_of_professional_experience' => $request->year_of_professional_experience,
            'pin_number' => $request->pin_number,
            'professional_certificate' => $save_url,
        ]);
        return redirect()->route('preview');
    }

    public function getRegions($district_id)
    {
        $regions = Region::whereHas('districts', function ($query) use ($district_id) {
            $query->where('id', $district_id);
        })->get();
        return response()->json($regions);
    }

    public function getBranches(Request $request)
    {
        $commissionType = session('commission_type');
        $armOfService = session('arm_of_service');
        if (is_null($commissionType) || is_null($armOfService)) {
            return response()->json(['error' => 'Session values missing'], 400);
        }
        $branches = Branch::where('commission_type', $commissionType)
            ->where('arm_of_service', $armOfService)
            ->get(['id', 'branch']);
        return response()->json($branches);
    }

    public function getCourses(Request $request)
    {
        $branchId = $request->input('branch_id');
        if (is_null($branchId)) {
            return response()->json(['error' => 'Branch ID missing'], 400);
        }
        $courses = Course::where('branch_id', $branchId)->where('status', 1)->get(['id', 'course_name']); // Adjust to actual column names
        return response()->json($courses);
    }

    // public function Declaration_and_Acceptance(Request $request)
    // {
    //     $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
    //     if (!$request->has('final_checked') || $request->input('final_checked') !== 'YES') {
    //         $disqualificationReason = 'You must accept the declaration to proceed.';
    //         return $this->disqualifyAndSave($disqualificationReason, $applicant);
    //     }
    //     $applicant->final_checked = 'YES';
    //     $applicant->card->status = 1;
    //     $randomString = Str::random(7);
    //     // Get the current year in 2 digits
    //     $year = Carbon::now()->format('y');
    //     // Determine the arm of service indicator
    //     $armIndicator = '';
    //     if ($applicant->arm_of_service === 'ARMY') {
    //         $armIndicator = 'X';
    //     } elseif ($applicant->arm_of_service === 'NAVY') {
    //         $armIndicator = 'Y';
    //     } elseif ($applicant->arm_of_service === 'AIRFORCE') {
    //         $armIndicator = 'Z';
    //     }
    //     // Get the branch name and split it into words
    //     $branchWords = explode(' ', strtoupper($applicant->branches->branch));
    //     // Generate the branch code
    //     $branchCode = '';
    //     if (count($branchWords) > 1) {
    //         // If more than one word, take the first letter of each word
    //         foreach ($branchWords as $word) {
    //             $branchCode .= $word[0];
    //         }
    //     } else {
    //         // If only one word, take the first letter
    //         $branchCode = substr($branchWords[0], 0, 1);
    //     }
    //     // Combine all parts to form the serial number
    //     $applicantSerialNumber = $randomString . $year . $armIndicator . $branchCode;
    //     // Save the serial number to the applicant and card models
    //     $applicant->applicant_serial_number = $applicantSerialNumber;
    //     $applicant->card->applicant_serial_number = $applicantSerialNumber;
    //     $applicant->card->save();
    //     // Retrieve the latest age limit date for the applicant's specific commission type
    //     $latestAgeLimitDate = AgeLimit::where('commission_type', $applicant->commission_type)
    //         ->orderBy('agelimit_date', 'desc')
    //         ->value('agelimit_date');
    //     if (!$latestAgeLimitDate) {
    //         $disqualificationReason = 'No age limit date found for your commission type.';
    //         return $this->disqualifyAndSave($disqualificationReason, $applicant);
    //     }
    //     // Convert the age limit date and applicant's date of birth into Carbon instances
    //     $ageLimitDate = Carbon::parse($latestAgeLimitDate);
    //     $dob = Carbon::parse($applicant->date_of_birth);
    //     // Calculate the applicant's age on the age limit date
    //     $ageAtDeadline = $dob->diffInYears($ageLimitDate);
    //     $exactAgeAtDeadline = $dob->diff($ageLimitDate);
    //     $applicant->age = $ageAtDeadline;
    //     // Convert height from feet.inches to meters
    //     $heightString = (string) $applicant->height;
    //     $heightParts = explode('.', $heightString);
    //     $feet = $heightParts[0];
    //     $inches = isset($heightParts[1]) ? $heightParts[1] : 0;
    //     $heightInInches = ($feet * 12) + $inches;
    //     $heightInMeters = $heightInInches * 0.0254;
    //     $weightInKg = $applicant->weight;
    //     $bmi = $weightInKg / ($heightInMeters * $heightInMeters);
    //     $bmiClassification = $this->classifyBmi($bmi);

    //     // check marital status
    //     if ($applicant->marital_status === 'MARRIED') {
    //         return $this->disqualifyAndSave('Married applicants are disqualified.', $applicant);
    //     }
    //     // Apply the specific age limit rules based on the commission type
    //     if ($applicant->commission_type === 'REGULAR') {
    //         if ($ageAtDeadline < 18 || $ageAtDeadline > 26) {
    //             $disqualificationReason = 'Applicant is over the age limit of 26 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
    //             return $this->disqualifyAndSave($disqualificationReason, $applicant);
    //         }
    //         if ($applicant->marital_status === 'MARRIED') {
    //             return $this->disqualifyAndSave('Married applicants are disqualified.', $applicant);
    //         }
    //         if ($bmi >= 25) {
    //             $disqualificationReason = 'Applicant is classified as ' . $bmiClassification . ' with a BMI of ' . number_format($bmi, 2) . '. This classification disqualifies you from proceeding.';
    //             return $this->disqualifyAndSave($disqualificationReason, $applicant);
    //         }
    //     } elseif ($applicant->commission_type === 'SHORT SERVICE') {
    //         if ($ageAtDeadline < 18 || $ageAtDeadline > 30) {
    //             $disqualificationReason = 'Applicant is over the age limit of 30 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
    //             return $this->disqualifyAndSave($disqualificationReason, $applicant);
    //         }
    //     } else {
    //         $disqualificationReason = 'Invalid commission type.';
    //         return $this->disqualifyAndSave($disqualificationReason, $applicant);
    //     }
    //     if (DB::table('applicants')->where('bece_index_number', $applicant->bece_index_number)->where('id', '<>', $applicant->id)->exists()) {
    //         return $this->disqualifyAndSave('BECE Index Number already exists.', $applicant);
    //     }
    //     // Mark the applicant as qualified
    //     $applicant->qualification = 'QUALIFIED';
    //     $applicant->disqualification_reason = null;
    //     $applicant->save();
    //     $pdfUrl = route('applicant-pdf');
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => $reason,
    //         'pdf_url' => $pdfUrl,
    //     ]);
    // }

    // protected function disqualifyAndSave($reason, $applicant)
    // {
    //     $applicant->qualification = 'DISQUALIFIED';
    //     $applicant->disqualification_reason = $reason;
    //     $applicant->save();
    //     $pdfUrl = route('applicant-pdf');
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => $reason,
    //         'pdf_url' => $pdfUrl,
    //     ]);
    // }

    // protected function classifyBmi($bmi)
    // {
    //     if ($bmi < 16) {
    //         return 'Severe Thinness';
    //     } elseif ($bmi >= 16 && $bmi < 17) {
    //         return 'Moderate Thinness';
    //     } elseif ($bmi >= 17 && $bmi < 18.5) {
    //         return 'Mild Thinness';
    //     } elseif ($bmi >= 18.5 && $bmi < 25) {
    //         return 'Normal';
    //     } elseif ($bmi >= 25 && $bmi < 30) {
    //         return 'Overweight';
    //     } elseif ($bmi >= 30 && $bmi < 35) {
    //         return 'Obese Class I';
    //     } elseif ($bmi >= 35 && $bmi < 40) {
    //         return 'Obese Class II';
    //     } else {
    //         return 'Obese Class III';
    //     }
    // }

    // public function Declaration_and_Acceptance(Request $request)
    // {
    //     $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
    //     $disqualificationReasons = [];
    //     // Check if the final declaration is accepted
    //     if (!$request->has('final_checked') || $request->input('final_checked') !== 'YES') {
    //         $disqualificationReasons[] = 'You must accept the declaration to proceed.';
    //     }
    //     // Check exam results and disqualify if necessary
    //     $this->checkExamResults($applicant, $disqualificationReasons);
    //     // Set applicant final check if no disqualification reason
    //     if (empty($disqualificationReasons)) {
    //         $applicant->final_checked = 'YES';
    //         $applicant->card->status = 1;
    //         $randomString = Str::random(7);

    //         // Serial number generation logic
    //         $year = Carbon::now()->format('y');
    //         $armIndicator = $this->getArmIndicator($applicant->arm_of_service);
    //         $branchCode = $this->generateBranchCode($applicant->branches->branch);
    //         $applicantSerialNumber = $randomString . $year . $armIndicator . $branchCode;

    //         // Save the serial number to the applicant and card models
    //         $applicant->applicant_serial_number = $applicantSerialNumber;
    //         $applicant->card->applicant_serial_number = $applicantSerialNumber;
    //         $applicant->card->save();
    //     }
    //     // Check age limit
    //     $latestAgeLimitDate = AgeLimit::where('commission_type', $applicant->commission_type)
    //         ->orderBy('agelimit_date', 'desc')
    //         ->value('agelimit_date');
    //     if (!$latestAgeLimitDate) {
    //         $disqualificationReasons[] = 'No age limit date found for your commission type.';
    //     } else {
    //         $ageAtDeadline = Carbon::parse($applicant->date_of_birth)->diffInYears(Carbon::parse($latestAgeLimitDate));
    //         $exactAgeAtDeadline = Carbon::parse($applicant->date_of_birth)->diff(Carbon::parse($latestAgeLimitDate));
    //     }
    //     // Check BMI and age based on commission type
    //     $bmi = $this->calculateBmi($applicant);
    //     $bmiClassification = $this->classifyBmi($bmi);
    //     if ($applicant->commission_type === 'REGULAR') {
    //         if (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 26)) {
    //             $disqualificationReasons[] = 'Applicant is over the age limit of 26 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
    //         }
    //         // Check marital status
    //         if ($applicant->marital_status === 'MARRIED') {
    //             $disqualificationReasons[] = 'Married applicants are disqualified.';
    //         }
    //         if ($bmi >= 25) {
    //             $disqualificationReasons[] = 'Applicant is classified as ' . $bmiClassification . ' with a BMI of ' . number_format($bmi, 2) . '. This classification disqualifies you from proceeding.';
    //         }
    //     } elseif ($applicant->commission_type === 'SHORT SERVICE') {
    //         if (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 30)) {
    //             $disqualificationReasons[] = 'Applicant is over the age limit of 30 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
    //         }
    //     } else {
    //         $disqualificationReasons[] = 'Invalid commission type.';
    //     }
    //     // Check BECE index number uniqueness
    //     if (DB::table('applicants')->where('bece_index_number', $applicant->bece_index_number)->where('id', '<>', $applicant->id)->exists()) {
    //         $disqualificationReasons[] = 'BECE Index Number already exists.';
    //     }

    //     // If there are disqualification reasons, handle disqualification
    //     if (!empty($disqualificationReasons)) {
    //         return $this->disqualifyAndSave($disqualificationReasons, $applicant);
    //     }

    //     // Mark the applicant as qualified
    //     $applicant->qualification = 'QUALIFIED';
    //     $applicant->disqualification_reason = null;
    //     $applicant->save();
    //     $pdfUrl = route('applicant-pdf');
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Applicant is qualified.',
    //         'pdf_url' => $pdfUrl,
    //     ]);
    // }

    public function Declaration_and_Acceptance(Request $request)
    {
        $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
        $disqualificationReasons = [];
        if (!$request->has('final_checked') || $request->input('final_checked') !== 'YES') {
            $disqualificationReasons[] = 'You must accept the declaration to proceed.';
        }
        // Set applicant final check and update card status if no disqualification reasons
        if (empty($disqualificationReasons)) {
            $applicant->final_checked = 'YES';
            $applicant->save(); // Save applicant first to persist final_checked
            $applicant->load('card');
            $applicant->card->status = 1;
            // Generate serial number and save to card
            $randomString = Str::random(7);
            $year = Carbon::now()->format('y');
            $armIndicator = $this->getArmIndicator($applicant->arm_of_service);
            $branchCode = $this->generateBranchCode($applicant->branches->branch);
            $applicantSerialNumber = $randomString . $year . $armIndicator . $branchCode;
            // Save the serial number to the card
            $applicant->card->applicant_serial_number = $applicantSerialNumber;
            $applicant->card->save();
            $applicant->qualification = 'QUALIFIED';
            $applicant->disqualification_reason = null;
            $applicant->save(); // Save applicant with qualification
        }
        // Check exam results and disqualify if necessary
        $this->checkExamResults($applicant, $disqualificationReasons);
        // Check age limit
        $latestAgeLimitDate = AgeLimit::where('commission_type', $applicant->commission_type)
            ->orderBy('agelimit_date', 'desc')
            ->value('agelimit_date');
        if (!$latestAgeLimitDate) {
            $disqualificationReasons[] = 'No age limit date found for your commission type.';
        } else {
            $ageAtDeadline = Carbon::parse($applicant->date_of_birth)->diffInYears(Carbon::parse($latestAgeLimitDate));
            $exactAgeAtDeadline = Carbon::parse($applicant->date_of_birth)->diff(Carbon::parse($latestAgeLimitDate));
        }
        // Check BMI and age based on commission type
        $bmi = $this->calculateBmi($applicant);
        $bmiClassification = $this->classifyBmi($bmi);
        if ($applicant->commission_type === 'REGULAR') {
            if ($applicant->branches->branch === 'MILITARY POLICE') {
                $height = (float) $applicant->height;
                // Height requirements: males >= 5.9 feet, females >= 5.7 feet
                if (($applicant->sex === 'MALE' && $height < 5.9) || ($applicant->sex === 'FEMALE' && $height < 5.7)) {
                    $disqualificationReasons[] = 'Height requirement minimum 5.9 feet for males and 5.7 feet for females.';
                }
            }
            if (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 26)) {
                $disqualificationReasons[] = 'Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            }
            if ($applicant->marital_status === 'MARRIED') {
                $disqualificationReasons[] = 'Married applicants are disqualified.';
            }
            if ($bmi >= 25) {
                $disqualificationReasons[] = 'Applicant is classified as ' . $bmiClassification . ' with a BMI of ' . number_format($bmi, 2) . '. This classification disqualifies you from proceeding.';
            }
        } elseif ($applicant->commission_type === 'SHORT SERVICE') {
            if ($applicant->branches->branch === 'ARCHITECT' && isset($ageAtDeadline) && $ageAtDeadline <= 40) {
                $disqualificationReasons[] = 'Applicants for the Architect branch in Short Service must be over 40 years old. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            } elseif (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 30)) {
                $disqualificationReasons[] = 'Applicant is over the age limit of 30 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            }
        } elseif ($applicant->commission_type === 'SPECIAL MEDICAL INTAKE (SMI)' && $applicant->branches->branch === 'MEDICAI AND DENTAL SPECIALISTS') {
            if (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 40)) {
                $disqualificationReasons[] = 'For Medical and Dental Specialists, your age must be between 18 and 40 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            }
        } elseif ($applicant->commission_type === 'SPECIAL MEDICAL INTAKE (SMI)' && $applicant->branches->branch === 'MEDICAL OFFICERS AND DENTAL SURGEONS') {
            if (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 35)) {
                $disqualificationReasons[] = 'For Medical Officers and Dental Surgeons, your age must be between 18 and 35 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            }
        } elseif ($applicant->commission_type === 'SPECIAL MEDICAL INTAKE (SMI)' && $applicant->branches->branch === 'NURSING OFFICER') {
            if (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 35)) {
                $disqualificationReasons[] = 'For Nursing Officers, your age must be between 18 and 35 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            }
        } elseif ($applicant->commission_type === 'SPECIAL MEDICAL INTAKE (SMI)' && $applicant->branches->branch === 'SPECIALISTS NURSE') {
            if (isset($ageAtDeadline) && ($ageAtDeadline < 18 || $ageAtDeadline > 35)) {
                $disqualificationReasons[] = 'For Specialist Nurse, your age must be between 18 and 35 years. Your age as of the deadline was ' . $exactAgeAtDeadline->y . ' years, ' . $exactAgeAtDeadline->m . ' months, and ' . $exactAgeAtDeadline->d . ' days.';
            }
        } else {
            $disqualificationReasons[] = 'Invalid commission type.';
        }
        if ($applicant->class_attained === 'PASS') {
            $disqualificationReasons[] = 'Applicants with "PASS" in class attained are disqualified.';
        }
        // Check BECE index number uniqueness
        if (DB::table('applicants')->where('bece_index_number', $applicant->bece_index_number)->where('id', '<>', $applicant->id)->exists()) {
            $disqualificationReasons[] = 'BECE Index Number already exists.';
        }
        // If there are disqualification reasons, handle disqualification
        if (!empty($disqualificationReasons)) {
            return $this->disqualifyAndSave($disqualificationReasons, $applicant);
        }
        $message = 'Dear ' . $applicant->first_name . $applicant->surname . ', your submission is complete.!';
        $this->smsService->sendSms($applicant->contact, $message);
        // Generate PDF URL
        $pdfUrl = route('applicant-pdf');
        return response()->json([
            'status' => 'success',
            'message' => 'Applicant is qualified.',
            'pdf_url' => $pdfUrl,
        ]);
    }

// Method to handle disqualification and save reasons
    protected function disqualifyAndSave($reasons, $applicant)
    {
        $applicant->qualification = 'DISQUALIFIED';
        $applicant->disqualification_reason = implode('; ', $reasons);
        $applicant->save();
        $pdfUrl = route('applicant-pdf');
        return response()->json([
            'status' => 'error',
            'message' => $reasons,
            'pdf_url' => $pdfUrl,
        ]);
    }
// Helper method to generate the arm indicator based on the arm of service
    protected function getArmIndicator($armOfService)
    {
        switch ($armOfService) {
            case 'ARMY':
                return 'X';
            case 'NAVY':
                return 'Y';
            case 'AIRFORCE':
                return 'Z';
            default:
                return '';
        }
    }
// Helper method to generate branch code based on branch name
    protected function generateBranchCode($branch)
    {
        $branchWords = explode(' ', strtoupper($branch));
        $branchCode = '';
        if (count($branchWords) > 1) {
            foreach ($branchWords as $word) {
                $branchCode .= $word[0];
            }
        } else {
            $branchCode = substr($branchWords[0], 0, 1);
        }
        return $branchCode;
    }

// Helper method to calculate the BMI of the applicant
    protected function calculateBmi($applicant)
    {
        $heightString = (string) $applicant->height;
        $heightParts = explode('.', $heightString);
        $feet = $heightParts[0];
        $inches = isset($heightParts[1]) ? $heightParts[1] : 0;
        $heightInInches = ($feet * 12) + $inches;
        $heightInMeters = $heightInInches * 0.0254;
        $weightInKg = $applicant->weight;
        return $weightInKg / ($heightInMeters * $heightInMeters);
    }

// Helper method to classify BMI
    protected function classifyBmi($bmi)
    {
        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi < 24.9) {
            return 'Normal weight';
        } elseif ($bmi < 29.9) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }
    protected function checkExamResults($applicant, &$disqualificationReasons)
    {
        $examTypes = [
            'exam_type_one',
            'exam_type_two',
            'exam_type_three',
            'exam_type_four',
            'exam_type_five',
            'exam_type_six',
        ];
        // Fetch subject names from the database or predefined list
        $subjectMappings = $this->getSubjectMappings($applicant);
        $examSubjects = array_keys($subjectMappings);
        // Track failed subjects to avoid repetition
        $failedSubjects = [];
        foreach ($examTypes as $index => $examType) {
            $examTypeValue = $applicant->{$examType};
            if ($examTypeValue === 'WASSCE' || $examTypeValue === 'PRIVATE') {
                $this->checkWassceAndPrivateGrades($applicant, $subjectMappings, $disqualificationReasons, $failedSubjects);
            } elseif ($examTypeValue === 'A LEVEL') {
                $this->checkALevelGrades($applicant, $subjectMappings, $disqualificationReasons, $failedSubjects);
            }
        }
    }
    // Fetch subject mappings from the database or a predefined list
    protected function getSubjectMappings($applicant)
    {
        return [
            'wassce_english_grade' => $applicant->wassce_english,
            'wassce_mathematics_grade' => $applicant->wassce_mathematics,
            'wassce_subject_three_grade' => $applicant->wassce_subject_three,
            'wassce_subject_four_grade' => $applicant->wassce_subject_four,
            'wassce_subject_five_grade' => $applicant->wassce_subject_five,
            'wassce_subject_six_grade' => $applicant->wassce_subject_six,
        ];
    }
    // Method to check WASSCE and PRIVATE exam grades
    protected function checkWassceAndPrivateGrades($applicant, $subjectMappings, &$disqualificationReasons, &$failedSubjects)
    {
        $failingGrades = ['D7', 'E8', 'F9'];
        foreach ($subjectMappings as $gradeField => $subjectName) {
            $grade = $applicant->{$gradeField};
            if (in_array($grade, $failingGrades)) {
                $failureMessage = "Failed $subjectName with grade $grade.";
                // Add to disqualificationReasons if not already added
                if (!in_array($failureMessage, $failedSubjects)) {
                    $disqualificationReasons[] = $failureMessage;
                    $failedSubjects[] = $failureMessage;
                }
            }
        }
    }
    // Method to check A LEVEL exam grades
    protected function checkALevelGrades($applicant, $subjectMappings, &$disqualificationReasons, &$failedSubjects)
    {
        $failingGrade = 'E';
        foreach ($subjectMappings as $gradeField => $subjectName) {
            $grade = $applicant->{$gradeField};
            if ($grade === $failingGrade) {
                $failureMessage = "Failed $subjectName with grade $grade.";
                // Add to disqualificationReasons if not already added
                if (!in_array($failureMessage, $failedSubjects)) {
                    $disqualificationReasons[] = $failureMessage;
                    $failedSubjects[] = $failureMessage;
                }
            }
        }
    }
}
