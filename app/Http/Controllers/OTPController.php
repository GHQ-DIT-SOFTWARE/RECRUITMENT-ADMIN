<?php
declare (strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OTPController extends Controller
{
    public function showVerifyOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric',
        ]);
        $otp_code = Session::get('otp_code');
        if ($request->otp_code == $otp_code) {
            Session::put('otp_verified', true);
            Session::forget('otp_code');
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('verify.otp')->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }
    }

}
