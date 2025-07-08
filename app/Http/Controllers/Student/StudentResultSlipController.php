<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentResultSlipController extends Controller
{
    //
    public function result_slip(){
        return view('student.result_slip.result_slip');
    }
}
