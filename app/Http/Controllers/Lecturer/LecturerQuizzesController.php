<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LecturerQuizzesController extends Controller
{
    //
    public function quizzes(){
        return view('lecturer.quizzes.quizzes');
    }
}
