<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCoursesModel;
use App\Models\Course;
use App\Models\User;
use App\Models\CategoryModel;
use App\Models\SubjectsModel;
use App\Models\SubjectMaterialsModel;



class AdminScoresController extends Controller
{
    //
    public function scores(){

        // Counts for other models
        $category = CategoryModel::count('id');
        $course_count = Course::count('id');
        $subject = SubjectsModel::count('id');
        $subject_materials = SubjectMaterialsModel::count('id');

        // Fetch all courses with instructors
        $courses = Course::with('users')->get(); // Ensure the 'users' relationship exists in CoursesModel


        return view('admin_academics.scores.scores',  compact(
            'category', 'course_count', 'subject', 'subject_materials', 'courses'
        ));
    }


    public function gradeStudent(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required|exists:users,id',
        'mark' => 'required|numeric|min:0|max:100',
    ]);

    $grading = GradingModel::updateOrCreate(
        ['student_id' => $validated['student_id']],
        ['mark' => $validated['mark']]
    );

    return response()->json(['success' => true, 'student_id' => $validated['student_id'], 'mark' => $validated['mark']]);
}


}
