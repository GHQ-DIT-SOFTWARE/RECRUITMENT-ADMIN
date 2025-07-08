@extends('admin.layout.master')
@section('title')
EDIT-USER
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashbaord</a></li>
                        <li class="breadcrumb-item"><a href="#!">Edit User{{ $user->name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title">Edit User - {{ $user->name }}</h4>
                        <a href="{{ route('index-user') }}" class="badge badge-primary">Back</a>
                    </div>
                    @include('admin.pages.systemsetting.users.part.message')

                    <form action="{{ route('update-user') }}" method="POST">
                        @csrf
                        <input type="hidden" name="uuid" value="{{ $user->uuid }}">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">User Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="Enter Phone Number" value="{{ $user->phone_number }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="appointment">Appointment</label>
                                <select class="form-control" id="appointment" name="appointment" required>
                                    <option value="">-- Select Appointment --</option>
                                    <option value="SYSTEM ADMIN" {{ $user->appointment == 'SYSTEM ADMIN' ? 'selected' : '' }}>SYSTEM ADMIN</option>
                                    <option value="PRINCIPAL" {{ $user->appointment == 'PRINCIPAL' ? 'selected' : '' }}>PRINCIPAL</option>
                                    <option value="DIRECTOR FINANCE" {{ $user->appointment == 'DIRECTOR FINANCE' ? 'selected' : '' }}>DIRECTOR FINANCE</option>
                                    <option value="LECTURER" {{ $user->appointment == 'LECTURER' ? 'selected' : '' }}>LECTURER</option>
                                    <option value="AUDIT" {{ $user->appointment == 'AUDIT' ? 'selected' : '' }}>AUDIT</option>
                                    <option value="ADMISSION" {{ $user->appointment == 'ADMISSION' ? 'selected' : '' }}>ADMISSION</option>
                                </select>
                            </div>

                            {{-- Assign Roles --}}
<div class="form-group col-md-12">
    <label>Assign Roles</label>
    <div class="row">
        @foreach ($roles as $role)
            <div class="col-md-6 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                        id="role_{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    <label class="form-check-label font-weight-bold" for="role_{{ $role->id }}">
                        {{ $role->name }}
                    </label>
                </div>

                {{-- Role Permissions Display Only (Not Editable) --}}
                <div class="ml-4 mt-2">
                    @if($role->permissions->count() > 0)
                        <small class="text-muted">Permissions via role:</small>
                        <div class="d-flex flex-wrap">
                            @foreach($role->permissions as $permission)
                                <span class="badge badge-secondary mr-1 mb-1">{{ $permission->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <small class="text-muted">No permissions assigned to this role.</small>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Direct Permissions --}}
<div class="form-group col-md-12 mt-4">
    <label>Assign Direct Permissions (Overrides role permissions)</label>
    <div class="d-flex flex-wrap">
        @foreach ($permissions as $permission)
            <div class="form-check form-check-inline mr-3 mb-2">
                <input class="form-check-input" type="checkbox" name="permissions[]"
                    value="{{ $permission->name }}" id="direct_permission_{{ $permission->id }}"
                    {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}>
                <label class="form-check-label" for="direct_permission_{{ $permission->id }}">
                    {{ $permission->name }}
                </label>
            </div>
        @endforeach
    </div>
</div>


                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#roles').select2({
                placeholder: "Select roles",
                allowClear: true
            });
        });
    </script>
@endsection
