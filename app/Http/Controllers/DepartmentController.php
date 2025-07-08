<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\department;
use App\Models\Faculty;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with('faculties')->latest()->get();
        $result = DataTables::of($query)
            ->addColumn('faculty', function ($record) {
                return $record->faculties ? $record->faculties->faculty_name : 'N/A';
            })
            ->addColumn('action', function ($record) {
                return '
                <a class="btn btn-info btn-sm" href="' . route('edit-faculty-department', $record->uuid) . '" title="Edit Data" id="edit"><i class="feather icon-edit"></i></a>
                <a class="btn btn-danger btn-sm" href="' . route('destroy-faculty-department', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
            })->make(true);
        return $result;
    }

    public function View()
    {
        $faculty = Faculty::get();
        return view('admin.pages.Department.index', compact('faculty'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'department' => 'required',
        ]);
        Department::create([
            'department' => $request->department,
            'faculty_id' => $request->faculty_id,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }

    public function Edit($uuid)
    {
        $department = Department::where('uuid', $uuid)->first();
        if (!$department) {
            abort(404);
        }
        $faculty = Faculty::get();
        return view('admin.pages.Department.edit', compact('department', 'faculty'));
    }

    public function Update(Request $request, $uuid)
    {
        $department = Department::where('uuid', $uuid)->first();
        if (!$department) {
            abort(404);
        }
        $department->faculty_id = $request->faculty_id;
        $department->department = $request->department;
        $department->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-faculty-department')->with($notification);
    }

    public function Delete($uuid)
    {
        $department = Department::where('uuid', $uuid)->first();
        if (!$department) {
            abort(404);
        }
        $department->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
