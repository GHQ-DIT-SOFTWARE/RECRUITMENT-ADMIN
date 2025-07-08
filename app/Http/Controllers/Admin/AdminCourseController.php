<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\OfferingCourse;

use Illuminate\Support\Facades\Auth;

class AdminCourseController extends Controller
{
    //
    public function courses()
    {
        return view('admin_academics.courses.courses');
    }

    public function getCourses()
    {
        $courses = OfferingCourse::orderBy('created_at', 'desc')->get();
        return response()->json($courses);
    }

    public function getCourseById($id)
    {
        $course = Course::find($id); // Correct model
        if ($course) {
            return response()->json($course);
        }
        return response()->json(['error' => 'Course not found'], 404);
    }


    public function course_add(Request $request)
    {
        $userID = Auth::id();
        $course = new Course();

        $course->user_id = $userID;
        $course->course_id = $request->input('course_id');
        $course->course_name = $request->input('course_name');
        $course->remarks = $request->input('remarks');
        $course->save();

        return redirect()->back();
    }


    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Handle JSON and form data
        $inputData = $request->all();

        // Check if JSON data exists
        if ($request->isJson()) {
            $inputData = $request->json()->all();
        }

        // Validate input
        $allowedFields = ['course_id', 'course_name', 'remarks'];
        foreach ($inputData as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $course->$key = $value;
            }
        }

        $course->save();

        return response()->json(['success' => true, 'message' => 'Course updated successfully']);
    }




    public function destroy($id)
    {
        $course = Course::find($id);

        if ($course) {
            $course->delete();
            return response()->json(['success' => true, 'message' => 'Course deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Course not found'], 404);
    }





    // public function materials(){
    //     return view('admin.courses.materials');
    // }

    public function report_courses()
    {
        return view('admin_academics.courses.report');
    }


    public function filterCourses(Request $request)
    {
        $query = Course::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        $courses = $query->orderBy('start_date', 'asc')->get();

        return response()->json($courses);
    }





    public function courses_allocation()
    {
        return view('admin_academics.allocations.allocations');
    }
}
