<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentAccountController extends Controller
{
    //
    public function account(){
        return view('student.account.account');
    }
}
