@extends('admin.layout.master')
@section('title')
    Applicant
@endsection
@section('content')
    <div class="user-profile user-card mb-4">
        <div class="card-body py-0">
            <div class="user-about-block m-0">
                <div class="row">
                    <div class="col-md-4 text-center mt-n5">
                        <div class="change-profile text-center">
                            <div class="dropdown w-auto d-inline-block">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="profile-dp">
                                        <div class="position-relative d-inline-block">
                                            @if ($applied_applicant->applicant_image)
                                                <img id="showImage" src="{{ asset($applied_applicant->applicant_image) }}"
                                                    alt="" class="img-thumbnail">
                                            @else
                                                <img id="showImage" src="{{ asset('uploads/profile_image.png') }}"
                                                    alt="" width="200px" class="img-thumbnail">
                                            @endif
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
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-upload-cloud mr-2"></i>upload new</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-image mr-2"></i>from
                                        photos</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-shield mr-2"></i>Protact</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="feather icon-trash-2 mr-2"></i>remove</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-1">{{ $applied_applicant->surname }} {{ $applied_applicant->other_names }}</h5>
                        <p class="mb-2 text-muted">{{ $applied_applicant->contact }}</p>
                    </div>
                    <div class="col-md-8 mt-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="mb-0 text-muted"><b> NHMC
                                                NUMBER: {{ $applied_applicant->applicant_serial_number }} </b></p>
                                        <p class="mb-0 text-muted">
                                            <b>COURSE SELECTED:</b> {{ $applied_applicant->cause_offers }}
                                        </p>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="mb-0 text-muted">
                                            @if ($applied_applicant->qualification == 'QUALIFIED')
                                                <span class="badge badge-success">
                                                    <b>STATUS:</b> {{ $applied_applicant->qualification }}</span>
                                            @elseif ($applied_applicant->qualification == 'PENDING')
                                                <span
                                                    class="badge badge-warning"><b>STATUS:</b>{{ $applied_applicant->qualification }}</span>
                                            @elseif ($applied_applicant->qualification == 'DISQUALIFIED')
                                                <span
                                                    class="badge badge-danger"><b>STATUS:</b>{{ $applied_applicant->qualification }}</span>
                                            @endif
                                        </p>
                                        <p class="mb-0 text-muted"><b>GENDER</b>: {{ $applied_applicant->sex }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs profile-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-reset active" id="home-tab" data-toggle="tab" href="#home"
                                    role="tab" aria-controls="home" aria-selected="true"><i
                                        class="feather icon-home mr-2"></i>Documentation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-reset" id="bodyselection-tab" data-toggle="tab"
                                    href="#bodyselection" role="tab" aria-controls="bodyselection"
                                    aria-selected="false"><i class="feather icon-user mr-2"></i>Body Selection</a>
                            </li>
                         

                         
                            <li class="nav-item">
                                <a class="nav-link text-reset" id="interview-tab" data-toggle="tab" href="#interview"
                                    role="tab" aria-controls="interview" aria-selected="false"><i
                                        class="feather icon-image mr-2"></i>Interview</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 order-md-2">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="font-weight-normal"><a href="#!" class="text-h-primary text-reset"><b
                                        class="font-weight-bolder">RESULTS VERFICATION PHASE</b></a></h5>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            @include('admin.pages.reports.parts.documentation')
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="bodyselection" role="tabpanel" aria-labelledby="bodyselection-tab">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">BODY SELECTION PHASE</h5>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="card-body border-top pro-det-edit collapse show" id="pro-det-edit-1">
                            @include('admin.pages.reports.parts.bodyselection')
                        </div>
                    </div>
                </div>

           
              
                <div class="tab-pane fade" id="interview" role="tabpanel" aria-labelledby="interview-tab">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">INTERVIEW PHASE</h5>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="card-body pt-0">
                            @include('admin.pages.reports.parts.interview')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
