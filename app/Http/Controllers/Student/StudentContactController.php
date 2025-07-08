<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentContactController extends Controller
{
    //
    public function contact(){
        return view('student.contact.contact');
    }
}
