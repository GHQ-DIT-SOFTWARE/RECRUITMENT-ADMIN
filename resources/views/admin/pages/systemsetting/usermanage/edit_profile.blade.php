@extends('admin.layout.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Profile</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Manage Profile</a></li>
                        <li class="breadcrumb-item"><a href="#!">Edit Profile</a></li>
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
                <div class="card-header">
                    <h5>Edit Profile</h5>
                </div>
                <div class="card-body">
                    <h5>Bio Data</h5>
                    <hr>
                    <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="svcnumber" class="col-sm-3 col-form-label">User Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $editData->name }}" required="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="surname" class="col-sm-3 col-form-label">Email:</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $editData->email }}" required="">
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                        class="col-sm-3 col-form-label col-form-label-sm">Gender</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="gender">
                                            <option value="" selected="" disabled="">Select Gender</option>
                                            <option value="Male" {{ $editData->gender == 'MALE' ? 'selected' : '' }}>MALE
                                            </option>
                                            <option value="Female" {{ $editData->gender == 'FEMALE' ? 'selected' : '' }}>
                                                FEMALE</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Profile Image:</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="image" class="form-control" id="image">
                                            <img id="showImage"
                                                src="{{ !empty($user->image) ? url('upload/user_images/' . $user->image) : url('upload/no_image.jpg') }}"
                                                style="width: 100px; width: 100px; border: 1px solid #000000;">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn  btn-primary" value="update">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
