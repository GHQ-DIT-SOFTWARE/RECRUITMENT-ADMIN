@extends('admin.layout.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit WASSCE</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">WASSCE</a></li>
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
                    <h5>Edit WASSCE.</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('subject.update-wassce-subject',$wasscesubject->uuid ) }}"method="POST" id="myForm">
                        @csrf
                        {{-- <input type="hidden" name="uuid" value="{{ $wasscesubject->uuid }}"> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Subject</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="wasscesubjects"
                                            value="{{ $wasscesubject->wasscesubjects }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">MAIN COURSE</label>
                                    <div class="col-sm-9">
                                        <select class="form-control"
        id="main_course"
        name="main_course">
    <option value="">Choose Course</option>
    <option value="GENERAL ARTS" {{ $wasscesubject->main_course == 'GENERAL ARTS' ? 'selected' : '' }}>
        GENERAL ARTS
    </option>
    <option value="SCIENCE" {{ $wasscesubject->main_course == 'SCIENCE' ? 'selected' : '' }}>
        SCIENCE
    </option>
    <option value="HOME ECONOMICS" {{ $wasscesubject->main_course == 'HOME ECONOMICS' ? 'selected' : '' }}>
        HOME ECONOMICS
    </option>
    <option value="AGRICULTURAL SCIENCE" {{ $wasscesubject->main_course == 'AGRICULTURAL SCIENCE' ? 'selected' : '' }}>
        AGRICULTURAL SCIENCE
    </option>
</select>

                                        @error('wasscesubjects')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn  btn-success">Update</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
