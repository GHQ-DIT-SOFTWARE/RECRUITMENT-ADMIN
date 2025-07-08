@extends('admin.layout.master')
@section('title')
    Roles
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Roles</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home">Role Edit -
                                    {{ $role->name }}</i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">Create Roles</a></li>
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
                        <h4 class="header-title">Edit Role</h4>
                        <a href="{{ route('index-roles') }}" class="badge badge-primary">Back</a>
                    </div>
                    @include('admin.pages.systemsetting.roles.part.message')
                    <form action="{{ route('update-roles') }}" method="post">
                        @csrf
                        <input type="hidden" name="uuid" value="{{ $role->uuid }}">
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $role->name }}"
                                name="name" placeholder="Enter a Role Name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1"
                                    {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                                <div class="row">
                                    @php
                                        $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                        $j = 1;
                                    @endphp
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="{{ $i }}Management" value="{{ $group->name }}"
                                                onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)"
                                                {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="checkPermission">{{ $group->name }}</label>
                                        </div>
                                    </div>

                                    <div class="col-9 role-{{ $i }}-management-checkbox">
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})"
                                                    name="permissions[]"
                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                    id="checkPermission{{ $permission->id }}"
                                                    value="{{ $permission->name }}">
                                                <label class="form-check-label"
                                                    for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                            @php  $j++; @endphp
                                        @endforeach
                                        <br>
                                    </div>
                                </div>
                                @php  $i++; @endphp
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('checkPermissionAll').onclick = function() {
            var checkboxes = document.querySelectorAll('.form-check-input[name="permissions[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }

            var groupCheckboxes = document.querySelectorAll('[id$="Management"]');
            for (var groupCheckbox of groupCheckboxes) {
                groupCheckbox.checked = this.checked;
                if (this.checked) {
                    checkPermissionByGroup(groupCheckbox.id.replace('Management', 'management-checkbox'),
                        groupCheckbox);
                } else {
                    checkPermissionByGroup(groupCheckbox.id.replace('Management', 'management-checkbox'),
                        groupCheckbox);
                }
            }
        }

        function checkPermissionByGroup(className, checkThis) {
            const classCheckBox = $('.' + className + ' input');
            if ($(checkThis).is(':checked')) {
                classCheckBox.prop('checked', true);
            } else {
                classCheckBox.prop('checked', false);
            }
            implementAllChecked();
        }

        function implementAllChecked() {
            const countPermissions = {{ count($permissions) }};
            const countPermissionGroups = {{ count($permission_groups) }};
            if ($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)) {
                $("#checkPermissionAll").prop('checked', true);
            } else {
                $("#checkPermissionAll").prop('checked', false);
            }
        }
    </script>
    {{-- <script>
        document.getElementById('checkPermissionAll').onclick = function() {
            var checkboxes = document.getElementsByName('permissions[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        function checkPermissionByGroup(className, checkThis) {
            const groupIdName = $("#" + checkThis.id);
            const classCheckBox = $('.' + className + ' input');

            if (groupIdName.is(':checked')) {
                classCheckBox.prop('checked', true);
            } else {
                classCheckBox.prop('checked', false);
            }
            implementAllChecked();
        }

        function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
            const classCheckbox = $('.' + groupClassName + ' input');
            const groupIDCheckBox = $("#" + groupID);

            // if there is any occurance where something is not selected then make selected = false
            if ($('.' + groupClassName + ' input:checked').length == countTotalPermission) {
                groupIDCheckBox.prop('checked', true);
            } else {
                groupIDCheckBox.prop('checked', false);
            }
            implementAllChecked();
        }

        function implementAllChecked() {
            const countPermissions = {{ count($permissions) }};
            const countPermissionGroups = {{ count($permission_groups) }};
            if ($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)) {
                $("#checkPermissionAll").prop('checked', true);
            } else {
                $("#checkPermissionAll").prop('checked', false);
            }
        }
    </script> --}}
@endsection
