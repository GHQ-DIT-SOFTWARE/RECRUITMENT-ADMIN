<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Aptitude;
use App\Models\BodySelection;
use Illuminate\Http\Request;

class BodySelectionController extends Controller
{
    public function applicant_bodyselection()
    {
        $data = Applicant::with(['regions', 'branches'])->get();
        return view('admin.pages.phases.bodyselection.report', compact('data'));
    }

    public function master_filter_applicant_bodyselection()
    {
        $data = BodySelection::with(['applicant.regions', 'applicant.branches'])->get();
        return view('admin.pages.phases.bodyselection.master_bodyselection', compact('data'));
    }

    public function applicant_bodyselection_status($uuid)
    {
        $applied_applicant = Applicant::with(['regions', 'branches'])->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.bodyselection.index', compact('applied_applicant'));
    }

    public function bodyselection_update($uuid)
    {
        // Retrieve the bodyselection record
        $bodyselection = BodySelection::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($bodyselection->applicant_id);
        return view('admin.pages.phases.bodyselection.update', compact('applied_applicant', 'bodyselection'));
    }

    // public function store_applicant_bodyselection(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'body_selection_status' => 'required',
    //         'body_selection_remarks' => 'required',
    //     ]);
    //     $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
    //     BodySelection::create([
    //         'applicant_id' => $applied_applicant->id,
    //         'body_selection_status' => $validatedData['body_selection_status'],
    //         'body_selection_remarks' => $validatedData['body_selection_remarks'],
    //     ]);
    //     return back()->with('success', 'Status saved successfully.');
    //     // return redirect()->route('bodyselection.applicant-body-selection')->with('success', 'status saved successfully.');
    // }

    public function store_applicant_bodyselection(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'body_selection_status' => 'required',
            'body_selection_remarks' => 'required',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if BodySelection record exists for this applicant
        $bodySelection = BodySelection::where('applicant_id', $applied_applicant->id)->first();
        // If no BodySelection record exists, return an error
        if (!$bodySelection) {
            return back()->with('error', 'No Body Selection record found for this applicant. Please check the documentation phase.');
        }
        // Check if body_selection_status is already set (not null)
        if (!is_null($bodySelection->body_selection_status)) {
            // If body_selection_status is already set, prevent updating and return an error
            return back()->with('error', 'Body Selection status has already been set and cannot be updated.');
        }
        // If body_selection_status is null, allow updating the record
        $bodySelection->update([
            'body_selection_status' => $validatedData['body_selection_status'],
            'body_selection_remarks' => $validatedData['body_selection_remarks'],
        ]);
        // Check if the applicant is QUALIFIED and create an entry in the next phase (Aptitude)
        if ($validatedData['body_selection_status'] === 'QUALIFIED') {
            // Check if an Aptitude record already exists for this applicant
            $aptitude = Aptitude::where('applicant_id', $applied_applicant->id)->first();
            // If no Aptitude record exists, create a new one
            if (!$aptitude) {
                Aptitude::create([
                    'applicant_id' => $applied_applicant->id,
                    // Add any other fields you want to save in Aptitude
                ]);
            }
        }
        // Redirect back with a success message
        return back()->with('success', 'Body Selection status updated successfully and next phase created (if qualified).');
    }

    public function confirm_applicant_bodyselection(Request $request, $uuid)
    {
        $applied_applicant = BodySelection::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }

        if ($request->body_selection_status === 'DISQUALIFIED' && $applied_applicant->body_selection_status === 'QUALIFIED') {
            // Find and delete the corresponding Interview record
            $aptitude = Aptitude::where('applicant_id', $applied_applicant->applicant_id)->first();
            if ($aptitude) {
                $$aptitude->delete();
            }
        }
        if ($request->body_selection_status === 'QUALIFIED' && $applied_applicant->body_selection_status === 'DISQUALIFIED') {
            // Check if an Interview record already exists for this applicant
            $aptitude = Aptitude::where('applicant_id', $applied_applicant->applicant_id)->first();
            // If no Interview record exists, create a new one
            if (!$aptitude) {
                Aptitude::create([
                    'applicant_id' => $applied_applicant->applicant_id,
                    // Add any other necessary fields for the Interview model
                ]);
            }
        }

        $applied_applicant->body_selection_status = $request->body_selection_status;
        $applied_applicant->body_selection_remarks = $request->body_selection_remarks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Status saved successfully.');
        // $notification = [
        //     'message' => 'Updated Successfully',
        //     'alert-type' => 'success',
        // ];
        // return redirect()->route('bodyselection.applicant-body-selection')->with($notification);
    }
}
