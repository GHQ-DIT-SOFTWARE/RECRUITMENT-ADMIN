<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCoursesModel;
use App\Models\PackagingModel;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentCourseModel;

class StudentCourseController extends Controller
{
    //
    public function courses()
    {
        $userID = Auth::id();
    
        // Fetch assigned courses with their packages
        $assignedCourses = UserCoursesModel::with(['course.packages.category'])
            ->where('user_id', $userID)
            ->get()
            ->groupBy('course_id'); // Group by course ID to avoid nested collections
    
        // Fetch already registered courses
        $registeredCourses = StudentCourseModel::where('user_id', $userID)
            ->pluck('category_id') // Get only category IDs
            ->toArray();
    
        return view('student.courses.courses', compact('assignedCourses', 'registeredCourses'));
    }




    public function register_courses(Request $request)
{
    $request->validate([
        'courses' => 'required|array',
        'level' => 'required',
        'semester' => 'required',
    ]);

    $studentId = Auth::id();

    // Get already registered courses for this student
    $existingCourses = StudentCourseModel::where('user_id', $studentId)
        ->pluck('category_id')
        ->toArray();

    foreach ($request->courses as $categoryId) {
        // Check if the course is already registered
        if (!in_array($categoryId, $existingCourses)) {
            StudentCourseModel::create([
                'user_id' => $studentId,
                'category_id' => $categoryId,
                'level' => $request->input('level'),
                'semester' => $request->input('semester'),
            ]);
        }
    }

    return response()->json(['success' => true, 'message' => 'Courses registered successfully']);
}



    
    
    
    
    
}
