<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserCoursesModel;
use App\Models\CategoryModel;
use App\Models\CoursesModel;
use App\Models\OfferingCourse;
use App\Models\SubjectsModel;
use App\Models\PackagingModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUsersController extends Controller
{
    //
    public function users()
    {
        return view('admin_academics.users.users');
    }



    public function store(Request $request)
    {
        $user = new User();

        $user->index_number = $request->input('index_number');
        $user->name = $request->input('name');
        $user->gender = $request->input('gender');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->gps = $request->input('gps');
        $user->service_no = $request->input('service_no');
        $user->role = $request->input('role');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->back();
    }



    public function getUsers()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }



    public function getUserseById($id)
    {
        $users = User::find($id); // Correct model
        if ($users) {
            return response()->json($users);
        }
        return response()->json(['error' => 'User not found'], 404);
    }


    public function update_users(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Handle JSON and form data
        $inputData = $request->all();

        // Check if JSON data exists
        if ($request->isJson()) {
            $inputData = $request->json()->all();
        }

        // Validate input
        $allowedFields = ['index_number', 'name', 'gender', 'email', 'phone', 'gps', 'service_no', 'role', 'password'];
        foreach ($inputData as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $user->$key = $value;
            }
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'User updated successfully']);
    }



    public function destroy_users($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }



    public function user_course_allocation()
    {
        // $packages = PackagingModel::with('course')
        //     ->select('id', 'level', 'semester')
        //     ->groupBy('id', 'level', 'semester')
        //     ->get();

        $packages = PackagingModel::all();
        $programs = OfferingCourse::all();

        $allocations = UserCoursesModel::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Group allocations by role
        $students = $allocations->where('user.role', 'Student');
        $lecturers = $allocations->where('user.role', 'Lecturer');

        return view('admin_academics.users.user_course_allocation', compact('packages','programs', 'students', 'lecturers'));
    }


    public function fetchStudents(Request $request)
    {
        Log::info('Fetching students', ['semester' => $request->semester, 'level' => $request->level]);

        // Check if semester and level are received
        if (!$request->has('semester') || !$request->has('level')) {
            return response()->json(['error' => 'Missing parameters'], 400);
        }

        try {
            $students = User::join('packages', 'users.id', '=', 'packages.user_id')
                ->where('packages.level', $request->level)
                ->where('packages.semester', $request->semester)
                ->select('users.*', 'packages.level', 'packages.semester') // Select necessary columns
                ->get();

            return response()->json($students);
        } catch (\Exception $e) {
            Log::error('Error fetching students: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }








    public function fetch_users(Request $request)
    {
        $role = $request->query('role');
        $users = User::where('role', $role)->get();
        return response()->json($users);
    }



    public function users_courses_store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'user_id' => 'required|array',
            'level' => 'required',
            'semester' => 'required',
        ]);

        \Log::info('Request Data:', $request->all());

        foreach ($request->input('user_id') as $userId) {
            $newEntry = UserCoursesModel::create([
                'course_id' => $request->input('course_id'),
                'user_id' => $userId,
                'level' => $request->input('level'),
                'semester' => $request->input('semester'),
            ]);

            \Log::info('Inserted Data:', $newEntry->toArray());
        }

        return redirect()->back()->with('success', 'Course assigned successfully!');
    }




    public function fetch_allocated_user()
    {
        $allocation = UserCoursesModel::with('category', 'subject', 'courses', 'users')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($allocation);
    }



    public function user_course_allocation_destroy($id)
    {
        $allocation = UserCoursesModel::find($id);

        if ($allocation) {
            $allocation->delete();
            return response()->json(['success' => true, 'message' => 'Allocation deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Allocation not found'], 404);
    }
}
