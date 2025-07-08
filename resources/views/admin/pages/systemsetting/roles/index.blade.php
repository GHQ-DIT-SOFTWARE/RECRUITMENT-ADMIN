@extends('admin.layout.master')
@section('title')
Roles
@endsection
@section('content')
    <style>
        #dataTable {
            font-size: 19px;
        }
    </style>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Roles </h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashbaord</a></li>
                        <li class="breadcrumb-item"><a href="#!">All Roles</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Roles List</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('web')->user()->can('superadmin.create'))
                            <a class="btn btn-primary text-white" href="{{ route('create-roles') }}">Create New Role</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Name</th>
                                    <th width="60%">Permissions</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->permissions as $perm)
                                                <span class="badge badge-info mr-1">
                                                    {{ $perm->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if (Auth::guard('web')->user()->can('superadmin.edit'))
                                                <a class="badge badge-success text-white"
                                                    href="{{ route('edit-roles', ['uuid' => $role->uuid]) }}">Edit</a>
                                            @endif

                                            @if (Auth::guard('web')->user()->can('superadmin.delete'))
                                                <a class="badge badge-danger text-white" id="delete"
                                                    href="{{ route('destroy-roles', $role->uuid) }}">
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
    <script>
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }
    </script>
    <script>
        $('#report-table').DataTable({
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ]
        });
    </script>
@endsection
