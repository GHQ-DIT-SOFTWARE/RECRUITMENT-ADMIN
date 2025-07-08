<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Front\Portal;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ApplicantPdfGenerationController extends Controller
{
    public function generatePdf(Request $request)
    {
        $applied_applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
        $pdf = Pdf::loadView('portal.pdf.applicant_pdf', compact('applied_applicant'));
        return $pdf->stream('applied_applicant.pdf');
    }
}
