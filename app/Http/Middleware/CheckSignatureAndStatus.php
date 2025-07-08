<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSignatureAndStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Ensure user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Ensure user has valid auth_status
        if ($user->status != 1) {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Require signature only if the user is a PRINCIPAL
        if ($user->appointment === 'PRINCIPAL' && empty($user->signature)) {
            return redirect()->route('signature.upload')->with('error', 'You must upload your signature to continue.');
        }

        return $next($request);
    }
}
