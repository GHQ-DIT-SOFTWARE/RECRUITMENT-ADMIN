<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Interview;
use App\Models\Vetting;
use Illuminate\Http\Request;

class VettingController extends Controller
{
    public function applicant_vetting()
    {
        $data = Applicant::with(['regions', 'branches'])->get();
        return view('admin.pages.phases.vetting.report', compact('data'));
    }
    // public function master_filter_applicant_vetting()
    // {
    //     $data = Applicant::with(['regions', 'branches'])->get();
    //     return view('admin.pages.phases.vetting.master_vetting', compact('data'));
    // }
    public function master_filter_applicant_vetting()
    {
        // Fetch applicants from the Vetting model with related data (regions and branches)
        $data = Vetting::with(['applicant.regions', 'applicant.branches'])->get();
        return view('admin.pages.phases.vetting.master_vetting', compact('data'));
    }

    public function applicant_vetting_status($uuid)
    {
        $applied_applicant = Applicant::with(['regions', 'branches'])->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.vetting.index', compact('applied_applicant'));
    }

    public function vetting_update($uuid)
    {
        // Retrieve the vettings record
        $vettings = Vetting::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($vettings->applicant_id);
        return view('admin.pages.phases.vetting.update', compact('applied_applicant', 'vettings'));
    }



    public function store_applicant_vetting(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'vetting_status' => 'required',
            'vetting_remarks' => 'required',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if an basicfitness record exists for this applicant
        $vettings = Vetting::where('applicant_id', $applied_applicant->id)->first();
        // If no basicfitness record exists, return an error
        if (!$vettings) {
            return back()->with('error', 'No vettings  record found for this applicant. Please check the documentation phase.');
        }
        // Check if vetting_status is already set (not null)
        if (!is_null($vettings->vetting_status)) {
            // If vetting_status is already set, prevent updating and return an error
            return back()->with('error', 'vettings  status has already been set and cannot be updated.');
        }
        // If vetting_status is null, allow updating the record
        $vettings->update([
            'vetting_status' => $validatedData['vetting_status'],
            'vetting_remarks' => $validatedData['vetting_remarks'],
        ]);
        // Check if the applicant is QUALIFIED and create an entry in the next phase (BasicFitness)
        if ($validatedData['vetting_status'] === 'QUALIFIED') {
            // Check if a BasicFitness record already exists for this applicant
            $interview = Interview::where('applicant_id', $applied_applicant->id)->first();
            // If no interview record exists, create a new one
            if (!$interview) {
                Interview::create([
                    'applicant_id' => $applied_applicant->id,
                    // Add any other fields you want to save in interview
                ]);
            }
        }
        // Redirect back with a success message
        return back()->with('success', 'Vetting  status updated successfully and next phase created (if qualified).');
    }



    public function confirm_applicant_vetting(Request $request, $uuid)
    {
        // Find the Vetting record by UUID
        $applied_applicant = Vetting::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }
        // Before saving, check if the status is changing to DISQUALIFIED
        if ($request->vetting_status === 'DISQUALIFIED' && $applied_applicant->vetting_status === 'QUALIFIED') {
            // Find and delete the corresponding Interview record
            $interview = Interview::where('applicant_id', $applied_applicant->applicant_id)->first();
            if ($interview) {
                $interview->delete();
            }
        }
        if ($request->vetting_status === 'QUALIFIED' && $applied_applicant->vetting_status === 'DISQUALIFIED') {
            // Check if an Interview record already exists for this applicant
            $interview = Interview::where('applicant_id', $applied_applicant->applicant_id)->first();
            // If no Interview record exists, create a new one
            if (!$interview) {
                Interview::create([
                    'applicant_id' => $applied_applicant->applicant_id,
                    // Add any other necessary fields for the Interview model
                ]);
            }
        }
        // Update the Vetting record
        $applied_applicant->vetting_status = $request->vetting_status;
        $applied_applicant->vetting_remarks = $request->vetting_remarks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Vetting status saved successfully.');
    }

}
