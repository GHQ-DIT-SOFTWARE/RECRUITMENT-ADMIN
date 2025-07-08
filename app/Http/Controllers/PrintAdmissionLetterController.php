<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Interview;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrintAdmissionLetterController extends Controller
{
    public function reprint_admission_letter()
    {
        $data = Interview::get();
        return view('admin.pages.admissionletter.admissionletter', compact('data'));
    }
    public function print_letter($uuid)
    {
        $applicant = Applicant::where('uuid', $uuid)->firstOrFail();
        $principal = User::where('appointment', 'PRINCIPAL')
            ->where('status', 1)
            ->first();

        $pdf = PDF::loadView('admin.pages.admissionletter.letter', compact('applicant', 'principal'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Admission_Letter_' . $applicant->surname . '.pdf');
    }

    // public function print_letter()
    // {
    //     $principal = User::where('appointment', 'PRINCIPAL')
    //         ->where('status', 1)
    //         ->first();
    //     return view('admin.pages.admissionletter.letter', compact('principal'));
    // }
}
