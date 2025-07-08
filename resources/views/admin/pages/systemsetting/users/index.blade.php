@extends('admin.layout.master')
@section('title')
USERS
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Records</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">View Users</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('alert'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('alert') }}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Users List</h4>
                    <p class="float-right mb-2">
                        <p class="float-right mb-2">
                            @if (Auth::guard('web')->user()->can('superadmin.create'))
                            <button class="btn btn-primary text-white rounded" data-toggle="modal" data-target="#createUserModal">Add User</button>
                                <button class="btn btn-primary text-white rounded" data-toggle="modal" data-target="#addRoleModal">Add Role</button>
                                <button class="btn btn-primary text-white rounded" data-toggle="modal" data-target="#createPermissionModal">Assign Permissions</button>
                            @endif
                        </p>
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('admin.pages.systemsetting.users.part.message')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th>Name</th>
                                    <th>Appointment</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Status</th>
                                    <th>Code (Default Password)</th>
                                    <th>Roles</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->appointment??'N/A' }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>
                                            @if ($user->status == 0)
                                                <a href="{{ route('user.inactive', $user->uuid) }}"
                                                    class="badge badge-danger sm" title="Inactive"
                                                    id="InactiveBtn">-Inactive</a>
                                            @elseif ($user->status == 1)
                                                <a href="{{ route('user.active', $user->uuid) }}"
                                                    class="badge badge-primary sm" title="Active" id="ActiveBtn">
                                                    - Active</a>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($user->code ==null)
                                               N/A
                                            @elseif ($user->code !=null)
                                           {{  $user->code }}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge badge-primary mr-1">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach

                                        </td>
                                        <td>
                                            {{-- @if (Auth::guard('web')->user()->can('superadmin.edit')) --}}
                                                <a class="badge badge-primary text-white"
                                                    href="{{ route('edit-user', $user->uuid) }}">Edit</a>
                                            {{-- @endif --}}
                                            @if (Auth::guard('web')->user()->can('superadmin.delete'))
                                                <a class="badge badge-danger text-white" id="delete"
                                                    href="{{ route('destroy-user', $user->uuid) }}">
                                                    Delete
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Create New User Modal -->
<!-- Create New User Modal -->

<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('store-user') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @include('admin.pages.systemsetting.users.part.message')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">User Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" pattern="\d{10}" minlength="10" maxlength="10" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment">Appointment</label>
                                <select class="form-control" id="appointment" name="appointment" required>
                                    <option value="">-- Select Appointment --</option>
                                    <option value="SYSTEM ADMIN">SYSTEM ADMIN</option>
                                    <option value="DIRECTOR FINANCE">DIRECTOR FINANCE</option>
                                    <option value="LECTURER">LECTURER</option>
                                    <option value="AUDIT">AUDIT</option>
                                    <option value="PRINCIPAL">PRINCIPAL</option>
                                    <option value="IT OFFICER">IT OFFICER</option>
                                     <option value="ADMISSION">ADMISSION</option>
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <label>Assign Roles</label>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}">
                                        <label class="form-check-label font-weight-bold" for="role_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>

                                    <div class="ml-4 mt-1">
                                        @if($role->permissions->count() > 0)
                                            @foreach($role->permissions as $permission)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}">
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <small class="text-muted">No permissions available.</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save User</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


    <!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role_name">Role Name</label>
                        <input type="text" name="name" class="form-control" id="role_name" required placeholder="Enter role name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create Role</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Assign Permission Modal -->
<div class="modal fade" id="assignPermissionModal" tabindex="-1" role="dialog" aria-labelledby="assignPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('roles.assign-permissions') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignPermissionModalLabel">Assign Permissions to Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Role Selection -->
                    <div class="form-group">
                        <label for="role">Select Role</label>
                        <select name="role_id" id="role" class="form-control" required>
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Permissions as Checkboxes -->
                    <div class="form-group">
                        <label>Assign Permissions</label>
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}">
                                        <label class="form-check-label" for="permission{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign Permissions</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Create Permission with Role Modal -->

<div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('roles.assign-permissions')}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPermissionModalLabel">Create New Permission and Assign Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="permissionName">Permission Name</label>
                        <input type="text" class="form-control" name="name" id="permissionName" placeholder="Enter permission name" required>
                    </div>

                    <div class="form-group">
                        <label for="role_id">Assign to Role</label>
                        <select name="role_id" id="role_id" class="form-control select2" required>
                            <option value="">--Select Role--</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create & Assign</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script>
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }
    </script>
@endsection
