<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\SubjectsModel;
use App\Models\SubjectAllocationModel;
use App\Models\SubjectMaterialsModel;
use App\Models\CoursesModel;
use Illuminate\Support\Facades\Auth;


class AdminSubjectController extends Controller
{
    //
    public function subjects()
    {
        return view('admin_academics.subjects.subjects');
    }


    public function subject_add(Request $request)
    {
        $userID = Auth::id();
        $subject = new SubjectsModel();

        $subject->user_id = $userID;
        $subject->subject_id = $request->input('subject_id');
        $subject->subject_name = $request->input('subject_name');
        $subject->subject_remarks = $request->input('subject_remarks');
        $subject->save();

        return redirect()->back();
    }



    public function getSubjects()
    {
        $subjects = SubjectsModel::orderBy('created_at', 'desc')->get();
        return response()->json($subjects);
    }




    public function destroy($id)
    {
        $subject = SubjectsModel::find($id);

        if ($subject) {
            $subject->delete();
            return response()->json(['success' => true, 'message' => 'Subject deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Subject not found'], 404);
    }


    public function update_subject(Request $request, $id)
    {
        $subject = SubjectsModel::findOrFail($id);

        // Handle JSON and form data
        $inputData = $request->all();

        // Check if JSON data exists
        if ($request->isJson()) {
            $inputData = $request->json()->all();
        }

        // Validate input
        $allowedFields = ['subject_id', 'subject_name', 'subject_remarks'];
        foreach ($inputData as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $subject->$key = $value;
            }
        }

        $subject->save();

        return response()->json(['success' => true, 'message' => 'Subject updated successfully']);
    }




    // public function getSubjects(Request $request)
    // {
    //     $categoryId = $request->query('category_id');

    //     if (!$categoryId) {
    //         return response()->json(['error' => 'Category ID is required'], 400);
    //     }

    //     $subjects = SubjectsModel::where('category_id', $categoryId)->get();

    //     return response()->json($subjects);
    // }



    public function getSubjectById($id)
    {
        $subject = SubjectsModel::find($id); // Correct model
        if ($subject) {
            return response()->json($subject);
        }
        return response()->json(['error' => 'Subject not found'], 404);
    }


    public function subject_material()
    {
        $courses = CoursesModel::orderby('created_at', 'desc')->get(['id', 'course_name']);
        $category = CategoryModel::orderby('created_at', 'desc')->get(['id', 'category_name', 'level']);
        $subjects = SubjectsModel::orderby('created_at', 'desc')->get(['id', 'subject_name']);

        return view('admin_academics.subjects.materials', compact('courses', 'category', 'subjects'));
    }

    public function getmaterial()
    {
        $material = SubjectMaterialsModel::with('category', 'subject', 'courses')->orderBy('created_at', 'desc')->get();
        return response()->json($material);
    }

    public function material_store(Request $request)
    {
        $userID = Auth::id();

        $request->validate([
            'course_id' => 'required',
            'category_id' => 'required',
            'subject_id' => 'required',
            'subject_video' => 'required|mimes:mp4,mov,avi,wmv',
            'subject_pdf' => 'required|mimes:pdf',
            'subject_remarks' => 'nullable|string',
        ]);

        // Store files
        $videoPath = $request->file('subject_video')->move(public_path('material/videos'), $request->file('subject_video')->getClientOriginalName());
        $pdfPath = $request->file('subject_pdf')->move(public_path('material/pdfs'), $request->file('subject_pdf')->getClientOriginalName());

        // Save record in DB
        SubjectMaterialsModel::create([
            'user_id' => $userID,
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
            'subject_id' => $request->subject_id,
            'video_path' => 'material/videos/' . $request->file('subject_video')->getClientOriginalName(),
            'pdf_path' => 'material/pdfs/' . $request->file('subject_pdf')->getClientOriginalName(),
            'subject_remarks' => $request->subject_remarks,
        ]);

        return redirect()->back()->with('success', 'Material added successfully!');
    }


    public function material_destroy($id)
    {
        // Find the material
        $material = SubjectMaterialsModel::find($id);

        if (!$material) {
            return response()->json(['error' => 'Material not found'], 404);
        }

        // Delete associated files (video & PDF)
        if (file_exists(public_path($material->video_path))) {
            unlink(public_path($material->video_path));
        }
        if (file_exists(public_path($material->pdf_path))) {
            unlink(public_path($material->pdf_path));
        }

        // Delete the material from database
        $material->delete();

        return response()->json(['success' => 'Material deleted successfully']);
    }


    public function subject_allocation()
    {
        $category = CategoryModel::orderby('created_at', 'desc')->get(['id', 'category_name']);
        $courses = CoursesModel::orderby('created_at', 'desc')->get(['id', 'course_id']);

        return view('admin_academics.subjects.allocation', compact('category', 'courses'));
    }


    public function allocation_store(Request $request)
    {
        $userID = Auth::id();
        $allocation = new SubjectAllocationModel;

        $allocation->user_id = $userID;
        $allocation->category_id = $request->input('category_id');
        $allocation->subject_id = $request->input('subject_id');
        $allocation->course_id = $request->input('course_id');
        $allocation->allocation_remarks = $request->input('allocation_remarks');
        $allocation->save();

        return redirect()->back();
    }

    public function getAllocation()
    {
        $allocation = SubjectAllocationModel::with('category', 'subject', 'course')->orderBy('created_at', 'desc')->get();
        return response()->json($allocation);
    }

    public function getAllocationtById($id)
    {
        $allocation = SubjectAllocationModel::find($id); // Correct model
        if ($allocation) {
            return response()->json($allocation);
        }
        return response()->json(['error' => 'Allocation not found'], 404);
    }

    public function update_allocation(Request $request, $id)
    {
        $allocation = SubjectAllocationModel::findOrFail($id);

        // Handle JSON and form data
        $inputData = $request->all();

        // Check if JSON data exists
        if ($request->isJson()) {
            $inputData = $request->json()->all();
        }

        // Validate input
        $allowedFields = ['category_id', 'subject_id', 'course_id', 'allocation_remarks'];
        foreach ($inputData as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $allocation->$key = $value;
            }
        }

        $allocation->save();

        return response()->json(['success' => true, 'message' => 'Allocation updated successfully']);
    }



    public function destroy_allocation($id)
    {
        $allocation = SubjectAllocationModel::find($id);

        if ($allocation) {
            $allocation->delete();
            return response()->json(['success' => true, 'message' => 'Allocation deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Allocation not found'], 404);
    }
}
