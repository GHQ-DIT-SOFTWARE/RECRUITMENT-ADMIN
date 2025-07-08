<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LecturerCourseController extends Controller
{
    //{
    public function materials(){
        return view('lecturer.courses.materials');
    }

    public function report_courses(){
        return view('lecturer.courses.report');
    }
}
