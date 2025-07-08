<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CategoryModel;
use App\Models\SubjectsModel;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignmentsModel;
use Illuminate\Support\Facades\Storage;


class AdminAssignmentController extends Controller
{
    //
    public function assignments(){
        $courses = Course::orderby('created_at','desc')->get(['id', 'course_name']);
        $category = CategoryModel::orderby('created_at','desc')->get(['id', 'category_name']);
        $subjects = SubjectsModel::orderby('created_at','desc')->get(['id', 'subject_name']);

        return view('admin_academics.assignments.assignments',compact('courses','category','subjects'));
    }

    public function assignment_store(Request $request)
    {
        $userID = Auth::id();

        $request->validate([
            'course_id' => 'required',
            'category_id' => 'required',
            'subject_id' => 'required',
            'assignment_id' => 'required',
            'assignment_name' => 'required|string',
            'assignment_pdf' => 'required|mimes:pdf',
            'assignment_remarks' => 'nullable|string',
        ]);

        if ($request->hasFile('assignment_pdf')) {
            $file = $request->file('assignment_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'assignments/' . $filename;

            // Move file to public/assignments/
            $file->move(public_path('assignments'), $filename);
        }

        // Store assignment details in DB
        $assignment = new AssignmentsModel();
        $assignment -> user_id = $userID;
        $assignment->course_id = $request->course_id;
        $assignment->category_id = $request->category_id;
        $assignment->subject_id = $request->subject_id;
        $assignment->assignment_id = $request->assignment_id;
        $assignment->assignment_name = $request->assignment_name;
        $assignment->assignment_pdf = $filePath; // Store path in DB
        $assignment->assignment_remarks = $request->assignment_remarks;
        $assignment->save();

        return redirect()->back()->with('success', 'Assignment uploaded successfully!');
    }


    public function assignment_destroy($id)
    {
        // Find the material
        $assignment = AssignmentsModel::find($id);

        if (!$assignment) {
            return response()->json(['error' => 'Assignment not found'], 404);
        }
        if (file_exists(public_path($assignment->assignment_pdf ))) {
            unlink(public_path($assignment->assignment_pdf ));
        }

        // Delete the assignment from database
        $assignment->delete();

        return response()->json(['success' => 'Assignment deleted successfully']);
    }


    public function getAssignment()
    {
        $assignment = AssignmentsModel::with('category','subject','courses')->orderBy('created_at','desc')->get();
        return response()->json($assignment);
    }



    public function assignment_marks(){

        return view('admin_academics.assignments.marks');
    }

    public function report_assignments(){
        $category = CategoryModel::all();
        return view ('admin_academics.assignments.report',compact('category'));
    }


    public function filterAssignments(Request $request)
    {
        $query = AssignmentsModel::query()
            ->join('categories', 'assignments.category_id', '=', 'categories.id')
            ->join('subjects', 'assignments.subject_id', '=', 'subjects.id')
            ->select(
                'assignments.assignment_id',
                'assignments.assignment_name',
                'assignments.created_at',
                'categories.category_name',
                'subjects.subject_name'
            );

        if ($request->filled('category_id')) {
            $query->where('assignments.category_id', $request->category_id);
        }

        if ($request->filled('subject_id')) {
            $query->where('assignments.subject_id', $request->subject_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('assignments.created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('assignments.created_at', '<=', $request->end_date);
        }

        return response()->json($query->get());
    }


    public function report_performance(){
        return view('admin_academics.performance.report');
    }
}
