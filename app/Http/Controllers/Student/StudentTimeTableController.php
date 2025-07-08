<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentTimeTableController extends Controller
{
    //
    public function time_table(){
        return view('student.time_table.time_table');
    }
}
