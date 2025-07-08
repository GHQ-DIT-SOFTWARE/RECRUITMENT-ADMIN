<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentAssignmentController extends Controller
{
    //
    public function assignments(){
        return view('student.assignments.assignments');
    }

    public function performance(){
        return view('student.performance.performance');
    }
}
