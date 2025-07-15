<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Medical;
use App\Models\Vetting;
use Illuminate\Http\Request;

class MedicalsController extends Controller
{
    public function applicant_medicals()
    {
        $data = Applicant::with(['regions', 'branches'])->get();
        return view('admin.pages.phases.medicals.report', compact('data'));
    }

    public function master_filter_applicant_medicals()
    {
        $data = Medical::with(['applicant.regions', 'applicant.branches'])->get();
        return view('admin.pages.phases.medicals.master_medicals', compact('data'));
    }
    
    public function applicant_medicals_status($uuid)
    {
        $applied_applicant = Applicant::with(['regions', 'branches'])->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.medicals.index', compact('applied_applicant'));
    }

    public function medicals_update($uuid)
    {
        // Retrieve the medicals record
        $medicals = Medical::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($medicals->applicant_id);
        return view('admin.pages.phases.medicals.update', compact('applied_applicant', 'medicals'));
    }

    // public function store_applicant_medicals(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'medical_status' => 'required',
    //         'medical_remarks' => 'required',
    //     ]);
    //     $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
    //     Medical::create([
    //         'applicant_id' => $applied_applicant->id,
    //         'medical_status' => $validatedData['medical_status'],
    //         'medical_remarks' => $validatedData['medical_remarks'],
    //     ]);
    //     return back()->with('success', 'Status saved successfully.');
    //     // return redirect()->route('test.applicant-medical')->with('success', 'status saved successfully.');
    // }

    public function store_applicant_medicals(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'medical_status' => 'required',
            'medical_remarks' => 'required',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if an basicfitness record exists for this applicant
        $medicals = Medical::where('applicant_id', $applied_applicant->id)->first();
        // If no basicfitness record exists, return an error
        if (!$medicals) {
            return back()->with('error', 'No medicals  record found for this applicant. Please check the documentation phase.');
        }
        // Check if medical_status is already set (not null)
        if (!is_null($medicals->medical_status)) {
            // If medical_status is already set, prevent updating and return an error
            return back()->with('error', 'medicals  status has already been set and cannot be updated.');
        }
        // If medical_status is null, allow updating the record
        $medicals->update([
            'medical_status' => $validatedData['medical_status'],
            'medical_remarks' => $validatedData['medical_remarks'],
        ]);
        // Check if the applicant is QUALIFIED and create an entry in the next phase (BasicFitness)
        if ($validatedData['medical_status'] === 'QUALIFIED') {
            // Check if a BasicFitness record already exists for this applicant
            $vettings = Vetting::where('applicant_id', $applied_applicant->id)->first();
            // If no vettings record exists, create a new one
            if (!$vettings) {
                Vetting::create([
                    'applicant_id' => $applied_applicant->id,
                    // Add any other fields you want to save in vettings
                ]);
            }
        }
        // Redirect back with a success message
        return back()->with('success', 'Medicals  status updated successfully and next phase created (if qualified).');
    }

    public function confirm_applicant_medicals(Request $request, $uuid)
    {
        $applied_applicant = Medical::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }
        if ($request->medical_status === 'DISQUALIFIED' && $applied_applicant->medical_status === 'QUALIFIED') {
            // Find and delete the corresponding Interview record
            $vetting = Vetting::where('applicant_id', $applied_applicant->applicant_id)->first();
            if ($vetting) {
                $vetting->delete();
            }
        }

        if ($request->medical_status === 'QUALIFIED' && $applied_applicant->medical_status === 'DISQUALIFIED') {
            // Check if an Interview record already exists for this applicant
            $vetting = Vetting::where('applicant_id', $applied_applicant->applicant_id)->first();
            // If no Interview record exists, create a new one
            if (!$vetting) {
                Vetting::create([
                    'applicant_id' => $applied_applicant->applicant_id,
                    // Add any other necessary fields for the Interview model
                ]);
            }
        }
        $applied_applicant->medical_status = $request->medical_status;
        $applied_applicant->medical_remarks = $request->medical_remarks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Status saved successfully.');
        // $notification = [
        //     'message' => 'Updated Successfully',
        //     'alert-type' => 'success',
        // ];
        // return redirect()->route('test.applicant-medical')->with($notification);
    }
}
