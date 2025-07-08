<?php

namespace App\Http\Controllers;

class LogactivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function login_and_logout_activities()
    {
        return view('admin.pages.systemsetting.usermanage.user_login_and_out_activities');
    }
    
}
