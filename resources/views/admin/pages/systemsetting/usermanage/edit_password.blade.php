@extends('admin.layout.master')
@section('content')
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">IMS</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Password</a></li>
                            <li class="breadcrumb-item"><a href="#!">Change Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Change Password </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{route('password.update')}}" method="post">
                                      @csrf
                                    <div class="form-group" >
                                        <label for="exampleInputPassword1">Current Password</label>
                                        <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder=" old password">
                                        @error('oldpassword')
                                          <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <small id="oldpassword" class="form-text text-muted">Type your Old password here.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">New Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="new password">
                                        @error('password')
                                          <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <small id="password" class="form-text text-muted">Type your new password here.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="confirm password">
                                        @error('password_confirmation')
                                        <span class="text-danger">{{$message}}</span>
                                      @enderror
                                        <small id="password_confirmation" class="form-text text-muted">Confirm your new password here.</small>
                                    </div>
                                    <button type="submit" class="btn  btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
            </div>
        </div>
            </div>

@endsection
