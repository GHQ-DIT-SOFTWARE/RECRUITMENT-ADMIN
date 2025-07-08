<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CategoryModel;
use App\Models\CoursesModel;
use App\Models\SubjectMaterialsModel;
use App\Models\SubjectsModel;
use App\Models\UserCoursesModel;


class AdminHomeController extends Controller
{
    //

    public function dashboard() {
        //Students
        $student_male = User::where('role','Student')->where('gender','Male')->count('id');
        $student_female = User::where('role','Student')->where('gender','Female')->count('id');
        $student_total = $student_male + $student_female;

        //Lecturers
        $lecturer_male = User::where('role','Lecturer')->where('gender','Male')->count('id');
        $lecturer_female = User::where('role','Lecturer')->where('gender','Female')->count('id');
        $lecturer_total = $lecturer_male + $lecturer_female;

        //Category
        $category_total = CategoryModel::count('id');

        //Courses
        $course_total = CoursesModel::count('id');

        //Subjects
        $subject_total = SubjectsModel::count('id');

        //Matterial
        $material_total = SubjectMaterialsModel::count('id');


        // Total students and lecturers
        $student_total = User::where('role', 'Student')->count();
        $instructor_total = User::where('role', 'Lecturer')->count();

        // Count total categories, subjects, and courses
        $category = CategoryModel::count();
        $course_count = CoursesModel::count();
        $subject = SubjectsModel::count();



        return view('admin_academics.home.dashboard', compact(
            'student_total', 'instructor_total', 'category', 'course_count','student_male',
            'student_female','student_total','lecturer_male','lecturer_female','lecturer_total','category_total',
            'course_total','subject_total','material_total'
        ));
    }



    public function getStudentCount(Request $request) {
        $courseId = $request->course_id;
        $lecturerId = $request->lecturer_id;

        // Count students allocated to the given course and lecturer
        $studentCount = UserCoursesModel::where('course_id', $courseId)
            ->whereHas('users', function ($query) {
                $query->where('role', 'Student'); // Ensure only students are counted
            })
            ->count();

        return response()->json(['student_count' => $studentCount]);
    }


    public function getStudentList(Request $request){
        $courseId = $request->course_id;
        $students = User::whereIn('id', UserCoursesModel::where('course_id', $courseId)->pluck('user_id'))
            ->where('role', 'Student')
            ->get();

        return response()->json(['students' => $students]);
    }




}
