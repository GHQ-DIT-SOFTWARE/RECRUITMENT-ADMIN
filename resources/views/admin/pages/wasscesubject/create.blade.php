@extends('admin.layout.master')
@section('title')
    MECH WASSCE SUBJECT
@endsection
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">WASSCE</h5>
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
                    <h5>Mech Region.</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('subject.store-wassce-subject')}}" method="POST" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">WASSCE SUBJECT</label>
                                    <div class="col-sm-9"><input type="text" class="form-control" name="wasscesubjects"
                                            placeholder="Subjects">
                                        @error('wasscesubjects')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">MAIN COURSE</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="main_course" name="main_course">
                                                                        <option value="">Choose Course</option>
                                                                        <option value="GENERAL ARTS">GENERAL ARTS</option>
                                                                        <option value="SCIENCE">SCIENCE</option>
                                                                        <option value="HOME ECONOMICS">HOME ECONOMICS</option>
                                                                        <option value="AGRICULTURAL SCIENCE">AGRICULTURAL SCIENCE</option>
                                                                    </select>
                                        @error('main_course')
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
                            <button type="submit" class="btn  btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
