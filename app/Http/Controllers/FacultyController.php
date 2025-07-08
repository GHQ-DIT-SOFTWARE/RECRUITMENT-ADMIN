<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use Illuminate\Validation\Rule;

class FacultyController extends Controller
{
    public function index()
    {
        $faculty = Faculty::get();
        return view('admin.pages.faculty.index', compact('faculty'));
    }

    public function Add()
    {
        return view('admin.pages.faculty.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'faculty_name' => 'required|unique:faculties,faculty_name',
        ]);
        Faculty::create([
            'faculty_name' => $request->faculty_name,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }

    public function Edit($uuid)
    {
        $faculty = Faculty::where('uuid', $uuid)->first();
        if (!$faculty) {
            abort(404);
        }
        return view('admin.pages.faculty.edit', compact('faculty'));
    }

    public function Update(Request $request, $uuid)
    {
        $faculty = Faculty::where('uuid', $uuid)->first();
        if (!$faculty) {
            abort(404);
        }
        $faculty->faculty_name = $request->faculty_name;
        $faculty->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-faculty')->with($notification);
    }


    public function Delete($uuid)
    {
        $faculty = Faculty::where('uuid', $uuid)->first();
        if (!$faculty) {
            abort(404);
        }
        $faculty->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
