<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class QualifiedApplicantMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $applicant;


    public function __construct($applicant)
    {
        $this->applicant = $applicant;
    }



    public function build()
    {
        // Find the principal user with auth_status = 1
        $principal = User::where('appointment', 'PRINCIPAL')
            ->where('status', 1)
            ->first();

        $pdf = Pdf::loadView('admin.pages.qualify-emails.qualified_applicant', [
            'applicant' => $this->applicant,
            'principal' => $principal,  // <-- pass principal here
        ]);
        return $this->subject('Offer of Admission to GAFCONM')
            ->view('admin.pages.qualify-emails.qualified_applicant', [
                'applicant' => $this->applicant,
                'principal' => $principal,  // pass here as well
            ])
            ->attachData($pdf->output(), "admission_letter.pdf", [
                'mime' => 'application/pdf',
            ]);

        // return $this->subject('Offer of Admission to GAFCONM')
        //     ->view('admin.pages.qualify-emails.qualified_applicant')
        //     ->attachData($pdf->output(), "admission_letter.pdf", [
        //         'mime' => 'application/pdf',
        //     ]);
    }


    // public function build()
    // {
    //     // Generate PDF using the existing Blade view
    //     $pdf = Pdf::loadView('admin.pages.qualify-emails.qualified_applicant', ['applicant' => $this->applicant]);
    //     return $this->subject('Offer of Admission to GAFCONM')
    //         ->view('admin.pages.qualify-emails.qualified_applicant') // Use a simple email template
    //         ->attachData($pdf->output(), "admission_letter.pdf", [
    //             'mime' => 'application/pdf',
    //         ]);
    // }

    // public function __construct($applicant)
    // {
    //     $this->applicant = $applicant;
    // }

    // public function build()
    // {
    //     return $this->subject('Congratulations! You Have Been Qualified 🎉')
    //         ->view('admin.pages.qualify-emails.qualified_applicant')
    //         ->with([
    //             'name' => $this->applicant->surname . ' ' . $this->applicant->other_names,
    //             'serialNumber' => $this->applicant->applicant_serial_number,
    //             'course' => $this->applicant->cause_offers,
    //         ]);
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
