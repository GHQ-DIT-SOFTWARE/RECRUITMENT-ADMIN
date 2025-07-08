<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LecturerAssignmentController extends Controller
{
    //
    public function assignments()
    {
        return view('lecturer.assignments.assignments');
    }

    public function assignment_marks()
    {
        return view('lecturer.assignments.marks');
    }

    public function report_assignments()
    {
        return view('lecturer.assignments.report');
    }

    public function report_performance()
    {
        return view('lecturer.performance.report');
    }
}
