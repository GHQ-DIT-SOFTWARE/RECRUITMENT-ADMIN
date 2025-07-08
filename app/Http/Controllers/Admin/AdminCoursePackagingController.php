<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CategoryModel;
use App\Models\SubjectsModel;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignmentsModel;
use App\Models\PackagingModel;
use App\Models\OfferingCourse;

class AdminCoursePackagingController extends Controller
{
    //
    public function course_packaging(){
        $courses = OfferingCourse::orderby('created_at','desc')->get(['id', 'cause_offers']);
        $category = CategoryModel::orderby('created_at','desc')->get(['id', 'category_name', 'level']);
        $subjects = SubjectsModel::orderby('created_at','desc')->get(['id', 'subject_name']);

        return view('admin_academics.packaging.packaging',compact('courses','category','subjects'));
    }

    public function fetchPackages()
    {
    $packages = PackagingModel::with(['course', 'category'])
        ->orderBy('level')
        ->orderByRaw("FIELD(semester, '1st Semester', '2nd Semester')")
        ->get();

    $groupedPackages = $packages->groupBy('course_id')->map(function ($levels) {
        return [
            'course' => [
                'id' => $levels->first()->course->id,
                'name' => $levels->first()->course->cause_offers,
            ],
            'levels' => $levels->groupBy('level')->map(function ($semesters) {
                return [
                    'level' => $semesters->first()->level,
                    'semesters' => $semesters->groupBy('semester')->map(function ($subjects) {
                        return [
                            'semester' => $subjects->first()->semester,
                            'subjects' => $subjects->map(function ($subject) {
                                return [
                                    'id' => $subject->id,
                                    'name' => $subject->category->category_name, // Assuming category holds the subject name
                                ];
                            })->values(),
                        ];
                    })->values(),
                ];
            })->values(),
        ];
    });

    return response()->json($groupedPackages);
    }




    public function add_course_packaging(Request $request) {
        $userID = Auth::id();

        $request->validate([
            'course_id' => 'required',
            'level' => 'required',
            'semester' => 'required',
            'category_id' => 'required|array',
        ]);

        foreach ($request->category_id as $categoryId) {
            $assignment = new PackagingModel();
            $assignment->user_id = $userID;
            $assignment->course_id = $request->course_id;
            $assignment->level = $request->level;
            $assignment->semester = $request->semester;
            $assignment->category_id = $categoryId; // Save individual ID
            $assignment->remarks = $request->remarks;

            $assignment->save();
        }

        return redirect()->back()->with('success', 'Package uploaded successfully!');
    }



    public function destroy($id)
    {
        $package = PackagingModel::find($id);
        if (!$package) {
            return response()->json(['error' => 'Package not found'], 404);
        }

        $package->delete();
        return response()->json(['success' => 'Package deleted successfully']);
    }


}
