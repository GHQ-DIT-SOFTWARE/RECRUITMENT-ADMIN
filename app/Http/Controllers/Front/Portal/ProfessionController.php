<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Portal;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('portal');
    }
    public function Profession_details()
    {
        $serial_number = session('serial_number');
        $pincode = session('pincode');
        $card = Card::where('serial_number', $serial_number)->where('pincode', $pincode)->first();
        $applied_applicant = Applicant::with('districts', 'regions')->where('card_id', $card->id)->first();
        return view('portal.profession', compact('applied_applicant'));
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

}
