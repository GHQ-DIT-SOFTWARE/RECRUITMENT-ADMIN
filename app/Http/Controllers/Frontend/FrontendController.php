<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoursesModel;

class FrontendController extends Controller
{
    //
    public function welcome(){
        $courses = CoursesModel::orderby('created_at','desc')->get();
        return view('welcome',compact('courses'));
    }
}
