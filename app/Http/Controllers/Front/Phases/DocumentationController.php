<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Phases;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Aptitude;
use App\Models\ResultVerification;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function applicant_documentation()
    {
        $data = Applicant::where('qualification','QUALIFIED')->get();
        return view('admin.pages.phases.documentation.report', compact('data'));
    }

    public function master_filter_applicant_documentation()
    {
        $data = ResultVerification::get();
        return view('admin.pages.phases.documentation.master_documentation', compact('data'));
    }

    public function applicant_result_verified($uuid)
    {
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.phases.documentation.index', compact('applied_applicant'));
    }

    public function documentation_update($uuid)
    {
        // Retrieve the documentation record
        $documentation = ResultVerification::where('uuid', $uuid)->firstOrFail();
        $applied_applicant = Applicant::findOrFail($documentation->applicant_id);
        return view('admin.pages.phases.documentation.update', compact('applied_applicant', 'documentation'));
    }

    public function store_applicant_documentation(Request $request, $uuid)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'result_verified' => 'required',
            'result_verified_remarks' => 'nullable',
        ]);
        // Find the applicant by UUID
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        // Check if a documentation record already exists for the applicant
        $existingDocumentation = ResultVerification::where('applicant_id', $applied_applicant->id)->first();
        // If a record exists, prevent adding the same record again
        if ($existingDocumentation) {
            return back()->with('error', 'Documentation status already exists for this applicant.');
        }
        // Create a new documentation record
        ResultVerification::create([
            'applicant_id' => $applied_applicant->id,
            'result_verified' => $validatedData['result_verified'],
            'result_verified_remarks' => $validatedData['result_verified_remarks'],
        ]);
        // Check if the applicant is qualified
        if ($validatedData['result_verified'] === 'QUALIFIED') {
            // Create an entry in the next phase (BodySelection)
            $aptitude = Aptitude::where('applicant_id', $applied_applicant->id)->first();
            // If no Aptitude record exists, create a new one
            if (!$aptitude) {
                Aptitude::create([
                    'applicant_id' => $applied_applicant->id,
                    // Add any other fields you want to save in Aptitude
                ]);
            }
        }
        $notification = [
            'message' => 'Applicant Verified Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('report.report-generation')->with($notification);
    }

    public function confirm_applicant_documentation(Request $request, $uuid)
    {
        $applied_applicant = ResultVerification::where('uuid', $uuid)->first();
        if (!$applied_applicant) {
            abort(404);
        }
        
        if ($request->result_verified === 'DISQUALIFIED' && $applied_applicant->result_verified === 'QUALIFIED') {
            // Find and delete the corresponding Interview record
            $bodyselection = Aptitude::where('applicant_id', $applied_applicant->applicant_id)->first();
            if ($bodyselection) {
                $$bodyselection->delete();
            }
        }

        if ($request->result_verified === 'QUALIFIED' && $applied_applicant->result_verified === 'DISQUALIFIED') {
            // Check if an Interview record already exists for this applicant
            $aptitude = Aptitude::where('applicant_id', $applied_applicant->id)->first();
            // If no Aptitude record exists, create a new one
            if (!$aptitude) {
                Aptitude::create([
                    'applicant_id' => $applied_applicant->id,
                    // Add any other fields you want to save in Aptitude
                ]);
            }
        }
        $applied_applicant->result_verified = $request->result_verified;
        $applied_applicant->result_verified_remarks = $request->result_verified_remarks;
        $applied_applicant->applicant_id = $request->applicant_id;
        $applied_applicant->save();
        return back()->with('success', 'Status saved successfully.');
    }

}
