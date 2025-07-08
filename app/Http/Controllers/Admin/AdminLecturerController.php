<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLecturerController extends Controller
{
    //
    public function lecturers(){
        return view('admin_academics.lecturers.lecturers');
    }
}
