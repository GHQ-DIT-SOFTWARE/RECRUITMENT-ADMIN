<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminQuizzesController extends Controller
{
    //
    public function quizzes(){
        return view('admin_academics.quizzes.quizzes');
    }
}
