<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QualifiedApplicantNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $date;
    public $time;
    public $venue;

    public function __construct($applicant, $date, $time, $venue)
    {
        $this->applicant = $applicant;
        $this->date = $date;
        $this->time = $time;
        $this->venue = $venue;
    }

    public function build()
    {
        return $this->subject('Aptitude Test Invitation')
            ->view('admin.pages.qualify-emails.results_verfication_notification', [
                'applicant' => $this->applicant,
                'date' => $this->date,
                'time' => $this->time,
                'venue' => $this->venue,
            ]);
    }
}
