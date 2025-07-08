<?php

declare(strict_types=1);

namespace App\Http\Controllers\Useraccount;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\CategoryModel;
use App\Models\OfferingCourse;
use App\Models\SubjectsModel;
use App\Models\UserCoursesModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class UserAccountController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        // if (is_null($this->user) || !$this->user->can('superadmin.view')) {
        //     abort(403, 'Sorry !! You are Unauthorized to view any user !');
        // }
        $inactiveUsers = User::where('status', 0)->get();
        if ($inactiveUsers->isNotEmpty()) {
            $alertMessage = 'The following user account is  inactive: ';
            foreach ($inactiveUsers as $user) {
                $alertMessage .= $user->name . ', ';
            }
            $alertMessage = rtrim($alertMessage, ', ');
            $alertMessage .= '.Please take necessary actions.';
            session()->flash('alert', $alertMessage);
        }
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.pages.systemsetting.users.index', compact('users', 'roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (is_null($this->user) || !$this->user->can('superadmin.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create any user !');
        // }
        $roles = Role::all();
        return view('admin.pages.systemsetting.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:users',
            'email' => 'required|max:100|email|unique:users',
            'phone_number' => 'required|digits:10',
        ]);

        // Generate 6-digit random code
        $defaultCode = rand(100000, 999999);

        // Create New User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->appointment = $request->appointment;
        $user->phone_number = $request->phone_number;
        $user->status = '1';
        $user->code = $defaultCode;
        $user->password = bcrypt($defaultCode); // Hash and save the default code
        $user->save();

        // Assign Roles
        if ($request->has('roles')) {
            $user->syncRoles($request->roles); // Detach previous roles and assign new ones
        }

        // Assign Permissions (individually)
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions); // Detach previous permissions and assign new ones
        }

        session()->flash('success', 'User has been created successfully!');
        return redirect()->route('index-user');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        // if (is_null($this->user) || !$this->user->can('superadmin.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        // }
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.pages.systemsetting.users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $uuid = $request->input('uuid');
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->appointment = $request->appointment;
        $user->phone_number = $request->phone_number;
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        if ($request->has('permissions')) {
            $user->permissions()->detach(); // Clear all direct permissions
            $user->givePermissionTo($request->permissions); // Assign new direct permissions
        }
        session()->flash('success', 'User has been updated !!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        // if (is_null($this->user) || !$this->user->can('superadmin.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        // }
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        $user->delete();
        session()->flash('success', 'User has been deleted !!');
        return back();
    }



    public function assignpermission(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'role_id' => 'required|exists:roles,id', // Ensure a valid role ID is provided
        ]);

        // Create a new permission with UUID and group_name
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->uuid = (string) Str::uuid(); // Generate UUID
        $permission->guard_name = 'web'; // Or your specific guard
        $permission->group_name = 'Custom Permissions'; // You can categorize permissions if needed
        $permission->save();
        // Find the role and assign the permission to it
        $role = Role::findOrFail($request->role_id);
        $role->givePermissionTo($permission); // This will assign the permission to the role
        session()->flash('success', 'Permission has been created and assigned successfully!');
        return back();
    }


    public function storerole(Request $request)
    {


        $request->validate([
            'name' => 'required|max:100|unique:roles',
        ], [
            'name.required' => 'Please give a role name',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'uuid' => Str::uuid()->toString(), // Manually set the UUID
        ]);

        $permissions = $request->input('permissions');
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been created !!');
        return back();
    }



    public function subject_allocation()
    {
        $courses = OfferingCourse::orderby('created_at', 'desc')->get(['id', 'cause_offers']);
        $category = CategoryModel::orderby('created_at', 'desc')->get(['id', 'category_name', 'level']);
        $subjects = SubjectsModel::orderby('created_at', 'desc')->get(['id', 'subject_name']);
        $users = User::where('appointment', 'LECTURER')->orderby('created_at', 'desc')->get(['id', 'name']);

        return view('admin.pages.systemsetting.subject_allocation.subject_allocation', compact('courses', 'category', 'subjects', 'users'));
    }



   public function getUserCoursesGrouped()
{
    $grouped = UserCoursesModel::with(['category', 'user'])
        ->get()
        ->groupBy('lecturer_id')
        ->map(function ($lecturerCourses) {
            $lecturer = $lecturerCourses->first()->user;

            return [
                'lecturer' => [
                    'id' => $lecturer->id ?? null,
                    'name' => $lecturer->name ?? 'Unknown',
                ],
                'levels' => $lecturerCourses->groupBy('level')->map(function ($levelGroup) {
                    return $levelGroup->groupBy('semester')->map(function ($semesterGroup) {
                        return $semesterGroup->map(function ($item) {
                            $decoded = json_decode($item->getRawOriginal('category_id'), true);
                            if (!is_array($decoded)) $decoded = [];

                            $names = \App\Models\CategoryModel::whereIn('id', $decoded)
                                ->pluck('category_name')
                                ->toArray();

                            return [
                                'category_names' => $names,
                                'remarks' => $item->remarks ?? '',
                                'id' => $item->id,
                            ];
                        })->values();
                    });
                }),
            ];
        })
        ->values();

    return response()->json($grouped);
}






    public function add_subject_allocation(Request $request)
    {
        $userID = Auth::id();
        $request->validate([
            'course_id' => 'required',
            'level' => 'required',
            'semester' => 'required',
            'lecturer_id' => 'required',
            'category_id' => 'required|array',

        ]);

        Log::info('Request Data:', $request->all());

        $newEntry = UserCoursesModel::create([
            'course_id' => $request->input('course_id'),
            'user_id' => $request->input('lecturer_id'), // using selected lecturer
            'level' => $request->input('level'),
            'semester' => $request->input('semester'),
            'lecturer_id' => $request->input('lecturer_id'),
            'category_id' => json_encode($request->input('category_id')),
            'remarks' => $request->input('remarks'),
        ]);


        Log::info('Inserted Data:', $newEntry->toArray());

        return redirect()->back()->with('success', 'Subjects Assigned successfully!');
    }

    public function showSignatureForm()
    {
        return view('auth.signature');
    }


    public function uploadsignature(Request $request)
    {
        $request->validate([
            'signature' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        if (!$user instanceof \Illuminate\Database\Eloquent\Model) {
            return back()->withErrors('Authenticated user is not valid.');
        }

        if ($user->signature) {
            return back()->with('warning', 'You have already uploaded your signature.');
        }

        if ($request->hasFile('signature')) {
            $image = $request->file('signature');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/signature/'), $name_gen);
            $user->signature = 'uploads/signature/' . $name_gen;
            $user->save();
        }
        return redirect()->route('dashboard.analysis-dashboard');
    }
}
