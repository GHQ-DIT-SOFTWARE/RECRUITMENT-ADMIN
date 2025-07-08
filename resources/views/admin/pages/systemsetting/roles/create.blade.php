@extends('admin.layout.master')
@section('title')
Roles
@endsection
@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Roles</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">Create Roles</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Create New Role</h4>
                    <form action="{{ route('store-roles') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter a Role Name">
                        </div>
                        <div class="form-group">
                            <label for="name">Permissions</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                id="{{ $i }}Management" value="{{ $group->name }}"
                                                onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                            <label class="form-check-label"
                                                for="checkPermission">{{ $group->name }}</label>
                                        </div>
                                    </div>
                                    <div class="col-9 role-{{ $i }}-management-checkbox">
                                        @php
                                            $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                            $j = 1;
                                        @endphp
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="permissions[]"
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
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Role</button>
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

            //  console.log((countPermissions + countPermissionGroups));
            //  console.log($('input[type="checkbox"]:checked').length);

            if ($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)) {
                $("#checkPermissionAll").prop('checked', true);
            } else {
                $("#checkPermissionAll").prop('checked', false);
            }
        }
    </script> --}}
@endsection
