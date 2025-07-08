<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassesModel;
use Illuminate\Support\Facades\Auth;

class AdminClassController extends Controller
{
    //
    public function classes(){
        return view ('admin_academics.classes.classes');
    }

    public function getClasses()
    {
        $classes = ClassesModel::orderBy('created_at','desc')->get();
        return response()->json($classes);
    }

    public function getClassById($id)
    {
        $class = ClassesModel::find($id);
        if ($class) {
            return response()->json($class);
        }
        return response()->json(['error' => 'Class not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $class = ClassesModel::findOrFail($id);
        $class->update($request->all());
        return response()->json(['success' => true, 'message' => 'Class updated successfully.']);
    }





    public function class_add(Request $request){
        $userID= Auth::id();
        $class = new ClassesModel();

        $class->user_id = $userID;
        $class->class_id = $request->input('class_id');
        $class->start_date = $request->input('start_date');
        $class->end_date = $request->input('end_date');
        $class->location = $request->input('location');
        $class->remarks = $request->input('remarks');
        $class->save();

        return redirect()->back();

    }


}
