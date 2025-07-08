<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\OfferingCourse;
use App\Models\Card;
use App\Models\CommissionType;
use App\Models\User;
use App\Notifications\ApplicantAppliedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PortalLogin extends Controller
{

    public function showPortalForm()
    {
        $arms = OfferingCourse::get();
        return view('auth.portal_login', compact('arms'));
    }

    public function verify()
    {
        return view('auth.otp_verify');
    }
    public function verify_reprint_summary_report_otp()
    {
        return view('auth.otp_for_reprint_summary_report');
    }
    public function PrintSummarySheet()
    {
        return view('auth.printsummarysheet');
    }

    public function print_summary_sheet(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'serial_number' => 'required|string',
            'pincode' => 'required|string',
            'contact' => 'required|string',
        ]);

        // Find the card with matching serial_number and pincode
        $card = Card::where('serial_number', $request->serial_number)
            ->where('pincode', $request->pincode)
            ->first();

        // If card doesn't exist, return an error
        if (!$card) {
            return back()->withErrors(['serial_number' => 'Invalid Serial Number or Pincode.']);
        }

        // If card status is not 1 (used), return an error
        if ($card->status != 1) {
            return back()->withErrors(['serial_number' => 'The card has not been used or is invalid.']);
        }

        // Check if applicant_serial_number is not null
        if ($card->applicant_serial_number == null) {
            return back()->withErrors(['serial_number' => 'No applicant is associated with this card.']);
        }

        // Fetch the applicant based on card_id
        $applied_applicant = Applicant::where('card_id', $card->id)->first();

        // If applicant is found, check if commission_type and arm_of_service match
        if ($applied_applicant) {
            if ($applied_applicant->commission_type !== $request->commission_type || $applied_applicant->arm_of_service !== $request->arm_of_service) {
                return back()->withErrors([
                    'commission_type' => 'The commission type or arm of service does not match the applicant\'s records.',
                ]);
            }
        } else {
            return back()->withErrors(['serial_number' => 'No applicant found for the given card ID.']);
        }

        // Check if the contact number exists in the applicant database
        $applicant_with_contact = Applicant::where('contact', $request->contact)->first();

        // If no applicant found with the contact, return an error
        if (!$applicant_with_contact) {
            return back()->withErrors(['contact' => 'No applicant found with the provided contact number.']);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in the session along with serial_number and pincode
        $request->session()->put('otp', $otp);
        $request->session()->put('serial_number', $request->serial_number);
        $request->session()->put('pincode', $request->pincode);
        $request->session()->put('card_id', $card->id);

        // Send OTP via SMS (use your SMS service here)
        send_sms($request->contact, "Hi Applicant,Your OTP is: $otp");

        // $adminUsers = User::where('is_admin', true)->get();

        // foreach ($adminUsers as $admin) {
        //     $admin->notify(new ApplicantAppliedNotification($adminUsers));
        // }
        // Redirect to the OTP verification page
        return redirect()->route('report-verify-otp');
    }

    // public function apply(Request $request)
    // {
    //     $request->validate([
    //         'serial_number' => 'required',
    //         'pincode' => 'required',
    //         'cause_offers' => 'required',
    //         'contact' => 'required|digits:10',
    //     ]);
    //     $card = Card::where('serial_number', $request->serial_number)
    //         ->where('pincode', $request->pincode)
    //         ->first();
    //     if (!$card) {
    //         return back()->withErrors(['serial_number' => 'Invalid Serial Number or Pincode.']);
    //     }
    //     if ($card->status == 1) {
    //         return back()->withErrors(['serial_number' => 'The card has already been used.']);
    //     }

    //     if ($card) {
    //         $applicant = Applicant::updateOrCreate(
    //             ['card_id' => $card->id],
    //             [
    //               'cause_offers' => $request->cause_offers,
    //                 'contact' => $request->contact,
    //             ]
    //         );
    //         // Store applicant details in the session
    //         $request->session()->put('serial_number', $request->serial_number);
    //         $request->session()->put('pincode', $request->pincode);
    //         $request->session()->put('card_id', $card->id);
    //         $request->session()->put('cause_offers', $request->cause_offers);
    //         // Generate OTP
    //         $otp = rand(100000, 999999); // Generates a 6-digit OTP
    //         // Save OTP in the session
    //         $request->session()->put('otp', $otp);
    //         // Send OTP via SMS
    //         send_sms($request->contact, "Your OTP is: $otp");
    //         // Redirect to OTP verification page
    //         return redirect()->route('verify-otp');
    //     }
    // }


    public function apply(Request $request)
    {
        $request->validate([
            'serial_number' => 'required',
            'pincode' => 'required',
            'cause_offers' => 'required',
            'contact' => 'required|digits:10',
        ]);

        $card = Card::where('serial_number', $request->serial_number)
            ->where('pincode', $request->pincode)
            ->first();

        if (!$card) {
            return back()->withErrors(['serial_number' => 'Invalid Serial Number or Pincode.']);
        }

        if ($card->status == 1) {
            return back()->withErrors(['serial_number' => 'The card has already been used.']);
        }

        // Check if the applicant has already applied
        $applicant = Applicant::where('card_id', $card->id)->first();

        if ($applicant) {
            // Prevent course change
            if ($applicant->cause_offers !== $request->cause_offers) {
                return back()->withErrors(['cause_offers' => 'You cannot change your selected course once applied.']);
            }
            // Update only contact information
            $applicant->update([
                'contact' => $request->contact,
            ]);
        } else {
            // New applicant record
            $applicant = Applicant::create([
                'card_id' => $card->id,
                'cause_offers' => $request->cause_offers,
                'contact' => $request->contact,
            ]);
        }

        // Store applicant details in the session
        $request->session()->put('serial_number', $request->serial_number);
        $request->session()->put('pincode', $request->pincode);
        $request->session()->put('card_id', $card->id);
        $request->session()->put('cause_offers', $applicant->cause_offers);

        // Generate and send OTP
        $otp = rand(100000, 999999);
        $request->session()->put('otp', $otp);
        send_sms($request->contact, "Your OTP is: $otp");

        return redirect()->route('verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);
        // Retrieve OTP from session
        $sessionOtp = $request->session()->get('otp');
        // Verify if the entered OTP matches the session OTP
        if ($request->otp == $sessionOtp) {
            // OTP is correct, clear OTP from session
            $request->session()->forget('otp');
            // Redirect to the bio-data page or any other portal page
            return redirect()->route('bio-data');
        } else {
            // OTP is incorrect
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }
    }

    public function verifyOtpreprint(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);
        $sessionOtp = $request->session()->get('otp');
        // Check if the entered OTP matches the OTP stored in the session
        if ($request->otp != $sessionOtp) {
            // OTP is incorrect, return with error
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }
        // OTP is correct, proceed to reprint the summary sheet
        return redirect()->route('applicant-pdf');
    }

    public function apply_logout(Request $request)
    {
        $applicant = Applicant::where('card_id', $request->session()->get('card_id'))->firstOrFail();
        $request->session()->forget(['serial_number', 'pincode', 'card_id']);
        // Regenerate the CSRF token (optional)
        $request->session()->regenerateToken();
        return response()->json(['status' => 'success']);
    }
}
