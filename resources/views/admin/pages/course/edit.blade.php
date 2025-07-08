@extends('admin.layout.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Sub Category</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Sub Category</a></li>
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
                    <h5>Edit Sub Category.</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('update-subcategory', $subcategory->uuid) }}" method="POST" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Sub Category</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sub_name"
                                            value="{{ $subcategory->sub_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="category_id"
                                        class="col-sm-4 col-form-label col-form-label-sm">Category</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="category_id">
                                            <option value=" ">Select Category</option>
                                            @foreach ($category as $sub)
                                                <option
                                                    value="{{ $sub->id }}"{{ $sub->id == $subcategory->category_id ? 'selected' : '' }}>
                                                    {{ $sub->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
