@extends('admin.layout.master')
@section('title')
Edit Department
@endsection
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Department</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Department</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Enter Department.</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('update-faculty-department', $department->uuid) }}" method="POST" id="myForm">
                        @csrf
                        <div class="form-group row">
                            <label for="faculty_id" class="col-sm-3 col-form-label">Faculty</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="faculty_id" name="faculty_id">
                                    <option value="">SELECT FACULTY</option>
                                    @foreach ($faculty as $list)
                                        <option value="{{ $list->id }}"
                                            {{ $department->faculty_id == $list->id ? 'selected' : '' }}>
                                            {{ $list->faculty_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                          </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="branch" class="col-sm-3 col-form-label">Department</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="department" placeholder="Department"
                                            value="{{ $department->department }}">
                                        @error('department')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn  btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
