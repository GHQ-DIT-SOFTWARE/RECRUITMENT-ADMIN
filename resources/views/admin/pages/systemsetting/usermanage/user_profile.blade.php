@extends('admin.layout.master')
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Profile</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="user-profile user-card mb-4">
        <div class="card-body py-0">
            <div class="user-about-block m-0">
                <div class="row">
                    <div class="col-md-4 text-center mt-n5">
                        <div class="change-profile text-center">
                            <div class="dropdown w-auto d-inline-block">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="profile-dp">
                                        <div class="position-relative d-inline-block">
                                            <img id="showImage"
                                                src="{{ !empty($user->image) ? url('upload/user_images/' . $user->image) : url('upload/no_image.jpg') }}"
                                                class="img-radius"
                                                style="width: 100px; width: 100px; border: 1px solid #000000;">
                                        </div>
                                        <div class="overlay">
                                            <span>change</span>
                                        </div>
                                    </div>
                                    <div class="certificated-badge">
                                        <i class="fas fa-certificate text-c-blue bg-icon"></i>
                                        <i class="fas fa-check front-icon text-white"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-upload-cloud mr-2"></i>upload new</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-trash-2 mr-2"></i>remove</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    </div>
                    <div class="col-md-8 mt-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="#!" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i
                                        class="feather icon-user mr-2 f-18"></i>User Name:{{ $user->name }}</a>
                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <a href="#!" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i
                                        class="feather icon-mail mr-2 f-18"></i>User-Email:{{ $user->email }}</a>
                            </div>
                            <div class="col-md-6">

                                <div class="clearfix"></div>
                                <a href="#" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i
                                        class="feather icon-users mr-2 f-18"></i>Gender:{{ $user->gender }}</a>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a href="{{ route('profile.edit') }}" class="btn  btn-primary " type="button"
                                    aria-haspopup="true" aria-expanded="false" style="float: right;"><i
                                        class="feather icon-edit"></i>Edit Profile</a>
                                <a class="nav-link text-reset has-ripple" id="profile-tab" data-toggle="tab" href="#profile"
                                    role="tab" aria-controls="profile" aria-selected="false">
                                    <i class="feather icon-user mr-2"></i>Profile<span class="ripple ripple-animate"
                                        style="height: 167.641px; width: 167.641px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(55, 58, 60); opacity: 0.4; top: -64.8205px; left: 4.492px;"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- profile header end -->
    <!-- profile body start -->
    <div class="row">
        <div class="col-md-8 order-md-2">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">UserAccount details</h5>
                            <button type="button" class="btn btn-primary btn-sm rounded m-0 float-right"
                                data-toggle="collapse" data-target=".pro-det-edit" aria-expanded="false"
                                aria-controls="pro-det-edit-1 pro-det-edit-2">
                                <i class="feather icon-edit"></i>
                            </button>
                        </div>
                        <div class="card-body border-top pro-det-edit collapse show" id="pro-det-edit-1">
                            <form>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-bolder">Full Name</label>
                                    <div class="col-sm-9">
                                        {{ $user->name }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-bolder">Gender</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="gender">
                                            <option value="" selected="" disabled="">Select Gender</option>
                                            <option value="Male" {{ $user->gender == 'MALE' ? 'selected' : '' }}>MALE
                                            </option>
                                            <option value="Female" {{ $user->gender == 'FEMALE' ? 'selected' : '' }}>
                                                FEMALE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-bolder">Email</label>
                                    <div class="col-sm-9">
                                        {{ $user->email }}
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-md-1">
            </div>
        </div>
        <!-- profile body end -->
    </div>
    <script src="{{ asset('assets/js/plugins/ekko-lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ac-lightbox.js') }}"></script>
    <script>
        // [ customer-scroll ] start
        var px = new PerfectScrollbar('.cust-scroll', {
            wheelSpeed: .5,
            swipeEasing: 0,
            wheelPropagation: 1,
            minScrollbarLength: 40,
        });
        // [ customer-scroll ] end
    </script>
@endsection
