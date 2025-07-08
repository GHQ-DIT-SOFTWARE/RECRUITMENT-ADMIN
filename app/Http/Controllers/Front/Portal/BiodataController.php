<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Portal;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Branch;
use App\Models\Card;
use App\Models\Course;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;

class BiodataController extends Controller
{
    public function __construct()
    {
        $this->middleware('portal');
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
        $applied_applicant = Applicant::where('card_id', $card->id)->first();
        
        
        return view('portal.biodata', compact( 'applied_applicant', 'ghanaian_languages', 'sports_interests'));
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

    public function saveBioData(Request $request)
    {
        $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
        $request->validate([
            // 'applicant_image' => 'required|image|mimes:jpg,png|max:2048',
            'applicant_image' => $applicant->applicant_image ? 'nullable|image|mimes:jpg,png|max:2048' : 'required|image|mimes:jpg,png|max:2048',
            'surname' => 'required',
            'other_names' => 'required',
            'sex' => 'required',
            'marital_status' => 'required',
            'date_of_birth' => 'required|date',
            'contact' => 'required|digits:10',
            'email' => 'required|email',
            'residential_address' => 'required',
            'language' => 'required|array',
            'disability_status'=>'required'
        ]);
        $save_url = $applicant->applicant_image;
        if ($request->hasFile('applicant_image')) {
            $image = $request->file('applicant_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('uploads/applicantimages/' . $name_gen);
            $save_url = 'uploads/applicantimages/' . $name_gen;
        }
        $applicant->update([
            'applicant_image' => $save_url,
            'surname' => $request->surname,
            'other_names' => $request->other_names,
            'sex' => $request->sex,
            'marital_status' => $request->marital_status,
            'date_of_birth' => $request->date_of_birth,
            'contact' => $request->contact,
            'email' => $request->email,
            'residential_address' => $request->residential_address,
            'national_identity_card' => $request->national_identity_card,
            'digital_address' => $request->digital_address,
            'language' => json_encode($request->language),
            'disability_status'=> $request->disability_status,
            'disability_reason'=> $request->disability_reason,
        ]);
        return redirect()->route('education-details');
    }
}
