<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    public static function sendNotification($applicant, $status, $disqualificationReasons = [])
    {
        $message = '';
        if ($status === 'QUALIFIED') {
            $message = 'Dear ' . $applicant->other_names . ' ' . $applicant->surname .
                       ', your application has been received! Your GAF NUMBER is ' .
                       $applicant->applicant_serial_number . '.';
        } elseif ($status === 'DISQUALIFIED') {
            $message = 'Dear ' . $applicant->other_names . ' ' . $applicant->surname .
                       ', we regret to inform you that your application has been disqualified due to the following reasons: ' .
                       implode('; ', $disqualificationReasons) . '.';
        }
        // Call send_sms function
        return send_sms($applicant->contact, $message);
    }
}
