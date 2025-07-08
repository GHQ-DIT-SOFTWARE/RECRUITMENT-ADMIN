<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminExamsController extends Controller
{
    //
    public function exams(){
        return view('admin_academics.exams.exams');
    }
}
