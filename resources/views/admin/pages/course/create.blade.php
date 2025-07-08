@extends('admin.layout.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Commission Type Details</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Commission Type</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Enter Course.</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('course.store-courses') }}" method="POST" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="course_name" class="col-sm-3 col-form-label">Course Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="course_name"
                                            placeholder="INFORMATION TECHNOLOGY">
                                        @error('course_name')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="branch_id" class="col-sm-3 col-form-label">Branch</label>
                                    <div class="col-sm-9">
                                        <select name="branch_id" class="form-control select2" required>
                                            <option selected="">Open this select menu</option>
                                            @foreach ($arm_of_service as $list)
                                                <option value="{{ $list->id }}">{{ $list->branch }}
                                                </option>
                                            @endforeach
                                            @error('branch_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn  btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
