<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CourseTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['service_branches']);
        $result = DataTables::of($query)
            ->addColumn('action', function ($record) {
                return '
                    <a class="btn btn-danger btn-sm" href="' . route('course.delete-courses', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->make(true);
        return $result;
    }

    public function toggleStatus($uuid)
    {
        $course = Course::where('uuid', $uuid)->first();
        if ($course) {
            $course->status = !$course->status;
            $course->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Course status updated successfully.',
                'new_status' => $course->status,
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Course not found.',
        ]);
    }

    public function getCommissionTypes(Request $request)
    {
        $armOfService = $request->input('arm_of_service');
        $commissionTypes = Course::where('arm_of_service', $armOfService)
            ->distinct()
            ->pluck('commission_type');
        return response()->json(['commission_types' => $commissionTypes]);
    }
    public function getBranches(Request $request)
    {
        $armOfService = $request->input('arm_of_service');
        $commissionType = $request->input('commission_type');
        $branches = Branch::whereHas('courses', function ($query) use ($armOfService, $commissionType) {
            $query->where('arm_of_service', $armOfService)
                ->where('commission_type', $commissionType);
        })->get(['id', 'branch as name']);
        return response()->json(['branches' => $branches]);
    }

    public function getCourses(Request $request)
    {
        $branchId = $request->input('branch_id');
        $armOfService = $request->input('arm_of_service');
        $commissionType = $request->input('commission_type');
        $courses = Course::where('branch_id', $branchId)
            ->where('arm_of_service', $armOfService)
            ->where('commission_type', $commissionType)
            ->get(['id', 'course_name as name']);
        return response()->json(['courses' => $courses]);
    }

    // public function toggleStatus(Request $request, $uuid)
    // {
    //     $course = Course::where('uuid', $uuid)->first();
    //     if ($course) {
    //         $course->status = !$course->status;
    //         $course->save();
    //         return response()->json(['success' => true, 'status' => $course->status]);
    //     }
    //     return response()->json(['success' => false]);
    // }

    public function View()
    {
        return view('admin.pages.course.index');
    }

    public function Add()
    {
        $arm_of_service = Branch::all();
        return view('admin.pages.course.create', compact('arm_of_service'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            // 'course_name' => ['required', Rule::unique('course_names')],
            'branch_id' => 'required',
        ]);
        Course::create([
            'course_name' => $request->course_name,
            'branch_id' => $request->branch_id,
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('course.courses-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $arm_of_service = Course::where('uuid', $uuid)->first();
        if (!$arm_of_service) {
            abort(404);
        }
        $main_of_service = Branch::all();
        return view('admin.pages.course.edit', compact('arm_of_service', 'main_of_service'));
    }

    public function Update(Request $request, $uuid)
    {
        $arm_of_service = Course::where('uuid', $uuid)->first();
        if (!$arm_of_service) {
            abort(404);
        }
        $arm_of_service->course_name = $request->course_name;
        $arm_of_service->branch_id = $request->branch_id;
        $arm_of_service->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('course.courses-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $arm_of_service = Course::where('uuid', $uuid)->first();
        if (!$arm_of_service) {
            abort(404);
        }
        $arm_of_service->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
