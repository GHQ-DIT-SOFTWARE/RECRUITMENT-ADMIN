<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LecturerExamsController extends Controller
{
    //
    public function exams(){
        return view('lecturer.exams.exams');
    }
}
