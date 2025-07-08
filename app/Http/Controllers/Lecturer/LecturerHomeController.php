<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LecturerHomeController extends Controller
{
    //
    public function dashboard()
    {
        return view('lecturer.home.dashboard');
    }
}
