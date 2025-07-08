<?php

declare(strict_types=1);

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $email = $request->email;
        $password = $request->password;
        // Check if the user exists with the given email
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
        }
        // Check if the user's account is active (status == 1)
        if ($user->status != 1) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Your account is deactivated. Please contact the administrator.']);
        }
        // Attempt to login if status is active
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $now = Carbon::now();
            $todayDate = $now->toDateTimeString();
            $activityLog = [
                'uuid' => Str::uuid(),
                'name' => $user->name,
                'email' => $user->email,
                'description' => 'has logged in',
                'date_time' => $todayDate,
            ];
            DB::table('activity_logs')->insert($activityLog);

            return redirect()->route('dashboard.index');
        }
        return redirect()->route('admin.login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }

    public function Logout()
    {
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $dt = Carbon::now();
        $todayDate = $dt->toDateTimeString();
        $activityLog = [
            'uuid' => Str::uuid(),
            'name' => $name,
            'email' => $email,
            'description' => 'has logged out',
            'date_time' => $todayDate,
        ];
        DB::table('activity_logs')->insert($activityLog);
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'User Logout Successfully');
    }

    public function verifyaccount()
    {
        return view('auth.verifyaccount');
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->password_changed_at = now();
        // $user->password_expiry = now()->addMonths(3);
        $user->password_expiry = Carbon::parse($user->password_changed_at)->addDays(90);
        $user->save();
        // Set session variable if password has expired
        if ($user->password_expiry < now()) {
            session()->flash('expired', true);
        }
        // Set session variable if it's the user's first login
        if (!$user->password_changed_at) {
            session()->flash('first_login', true);
        }

        return redirect()->route('admin.login')->with('info', 'Password changed successfully. You can now login with your new password.');
    }
}
