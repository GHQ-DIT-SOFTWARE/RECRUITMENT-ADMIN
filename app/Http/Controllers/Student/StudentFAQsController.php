<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentFAQsController extends Controller
{
    //
    public function faqs(){
        return view('student.faqs.faqs');
    }
}
