<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front\Reports;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportGenerationController extends Controller
{
    public function reports()
    {
        $data = Applicant::get();
        return view('admin.pages.reports.report', compact('data'));
    }

    public function applicant_pdf($uuid)
    {
        $applied_applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        $pdf = Pdf::loadView('admin.pages.reports.pdf.applicant_pdf', compact('applied_applicant'));
        return $pdf->stream('applied_applicant' . $uuid . 'pdf');
    }


    public function deleteApplicant($uuid)
    {
        $applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        $applicant->delete();
        return redirect()->back()->with('success', 'Applicant deleted successfully');
    }

    public function showApplicantPhases($uuid)
    {
        $applied_applicant = Applicant::with([
            'documentation_phase',
            'bodySelection_phase',
            'aptitude_phase',
            'basicfitness',
            'outdoorfitness_phase',
            'medicals_phase',
            'vetting_phase',
            'interview_phase',
        ])->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.reports.applicant_phases', compact('applied_applicant'));
    }

    public function applicant_preview_data()
    {
        $applied_applicant = Applicant::with(['regions', 'branches'])->get();
        return view('admin.pages.correctapplicantdata.previewdatatable', compact('applied_applicant'));
    }
}
