<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\SubjectsModel;
use Illuminate\Support\Facades\Auth;

class AdminStudentController extends Controller
{
    //
    public function students(){

        return view('admin_academics.students.students');
    }
}
