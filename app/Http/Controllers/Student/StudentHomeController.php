<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentHomeController extends Controller
{
    //
    public function dashboard(){
        return view('student.home.dashboard');
    }
}
