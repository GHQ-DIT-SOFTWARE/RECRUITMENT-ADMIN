<?php
declare (strict_types = 1);
namespace App\Http\Controllers\RolesandPermission;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionController extends Controller
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
        $roles = Role::all();
        return view('admin.pages.systemsetting.roles.index', compact('roles'));
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
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.pages.systemsetting.roles.create', compact('permissions', 'permission_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        // $role = Role::findById($id, 'web');
        $role = Role::where('uuid', $uuid)->first();
        if (!$role) {
            abort(404);
        }
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.pages.systemsetting.roles.edit', compact('role', 'permissions', 'permission_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // if (is_null($this->user) || !$this->user->can('superadmin.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        // }
        $uuid = $request->input('uuid');
        $role = Role::where('uuid', $uuid)->first();
        if (!$role) {
            abort(404);
        }
        $permissions = $request->input('permissions');
        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
        }
        session()->flash('success', 'Role has been updated !!');
        return back();
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
        //     abort(403, 'Sorry !! You are Unauthorized to delete any role !');
        // }
        $role = Role::where('uuid', $uuid)->first();
        if (!$role) {
            abort(404);
        }
        $role->delete();
        session()->flash('success', 'Role has been deleted !!');
        return back();
    }
}
