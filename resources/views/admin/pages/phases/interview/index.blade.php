@extends('admin.layout.master')
@section('title')
    Interview Phase
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
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 order-md-2">
            <div class="card">
                <h4 style="padding:20px">INTERVIEW PHASE</h4>
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
                    <form method="POST" action="{{ route('test.status-save-interview', $applied_applicant->uuid) }}">
                        @csrf
                        <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="custom-select" name="interview_status" required>
                                    <option value="">Open this select menu</option>
                                    <option value="QUALIFIED">QUALIFIED</option>
                                    <option value="DISQUALIFIED">DISQUALIFIED</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="interview_marks" placeholder="marks">
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
