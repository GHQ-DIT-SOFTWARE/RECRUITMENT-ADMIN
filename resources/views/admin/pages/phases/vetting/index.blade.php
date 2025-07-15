@extends('admin.layout.master')
@section('title')
    Vetting Phase
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
                            </div>
                        </div>
                        <h5 class="mb-1">{{ $applied_applicant->surname }} {{ $applied_applicant->other_names }}</h5>
                    </div>
                    <div class="col-md-8 mt-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="mb-0 text-muted"><b> GAF
                                                NUMBER: {{ $applied_applicant->applicant_serial_number }} </b></p>
                                        <p class="mb-0 text-muted">
                                            <b>ARM OF
                                                SERVICE:</b> {{ $applied_applicant->arm_of_service }}
                                        </p>
                                        <p class="mb-0 text-muted"> <b>COMMISSION TYPE:</b>
                                            {{ $applied_applicant->commission_type }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="mb-0 text-muted"> <b>BRANCH:</b>
                                            {{ $applied_applicant->branches->branch }}</p>
                                        <p class="mb-0 text-muted">
                                            @if ($applied_applicant->qualification == 'QUALIFIED')
                                                <span class="badge badge-success">
                                                    <b>STATUS:</b> {{ $applied_applicant->qualification }}</span>
                                            @elseif($applied_applicant->qualification == 'PENDING')
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

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 order-md-2">
            <div class="card">
                <h4 style="padding:20px">VETTING PHASE</h4>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('test.status-save-vetting', $applied_applicant->uuid) }}">
                        @csrf
                        <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="custom-select" name="vetting_status" required>
                                    <option value="">Open this select menu</option>
                                    <option value="QUALIFIED">QUALIFIED</option>
                                    <option value="DISQUALIFIED">DISQUALIFIED</option>
                                    <option value="PENDING">PENDING</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="vetting_remarks"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
