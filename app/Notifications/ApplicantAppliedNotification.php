<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicantAppliedNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    use Queueable;

    protected $applicant;

    public function __construct($applicant)
    {
        $this->applicant = $applicant;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New applicant has applied: ' . $this->applicant->surname . ' ' . $this->applicant->first_name . ' ' . $this->applicant->other_names,
            'applicant_id' => $this->applicant->id,
        ];
    }
}
