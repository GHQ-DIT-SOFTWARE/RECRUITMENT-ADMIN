@extends('admin.layout.master')
@section('title')
    Preview Applicant
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <nav class="navbar justify-content-between p-0 align-items-center">
                            <h5>Home</h5>
                        </nav>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">ARM OF SERVICE:
                                {{ $applied_applicant->arm_of_service }}</a></li>
                        <li class="breadcrumb-item"><a href="#!">COMMISSION TYPE:
                                {{ $applied_applicant->commission_type }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="text-align: center; font-family: Arial Black, Helvetica, sans-serif;">
                        GHANA ARMED FORCES - ONLINE ENLISTMENT PORTAL
                    </h4>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('disqualification_reasons') && !empty(session('disqualification_reasons')))
                        <div class="alert alert-warning">
                            <strong>Disqualification Reasons:</strong>
                            <ul>
                                @foreach (session('disqualification_reasons') as $reason)
                                    <li>{{ $reason }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Application Form</h5>
                </div>
                <div class="card-body" style="margin-left: 2cm; margin-right: 2cm;">
                    <div class="bt-wizard" id="progresswizard">
                        <ul class="nav nav-pills nav-fill mb-3"
                            style="text-align: center; font-family: Arial Black, Helvetica, sans-serif;">
                            <li class="nav-item"><a href="#b-w-tab1" class="nav-link active" data-toggle="tab">APPLICANT
                                    DETAILS</a></li>
                        </ul>
                        <div id="bar" class="bt-wizard progress mb-3" style="height:6px">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active show" id="b-w-tab1" style="text-align: right">
                                <form id="form1"
                                    action="{{ route('correct.applicant.corrections.update', $applied_applicant->uuid) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        @php
                                            $imagePath = public_path($applied_applicant->applicant_image);
                                        @endphp
                                        <div class="col-md-2 border-right">
                                            <div class="d-flex flex-column align-items-center text-center p-1 py-5">
                                                @if (file_exists($imagePath))
                                                    <img id="showImage"
                                                        src="{{ asset($applied_applicant->applicant_image) }}"
                                                        alt="" class="rounded-circle mt-2" height="150px"
                                                        width="150px">
                                                @else
                                                    <img id="showImage"
                                                        src="{{ asset('assets/images/img_placeholder_avatar.jpg') }}"
                                                        alt="" class="rounded-circle mt-2" height="150px"
                                                        width="150px">
                                                @endif
                                                <span class="font-weight-bold">Photo</span>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group row">
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Surname</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="surname" name="surname"
                                                        placeholder=""
                                                        value="{{ old('surname', $applied_applicant->surname) }}">
                                                </div>
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Other
                                                    Name(s)</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="other_names"
                                                        name="other_names" placeholder=""
                                                        value="{{ old('other_names', $applied_applicant->other_names) }}">
                                                </div>
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Sex</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control required" id="sex" name="sex">
                                                        <option value="">Select</option>
                                                        <option value="MALE"
                                                            {{ old('sex', $applied_applicant->sex) == 'MALE' ? 'selected' : '' }}>
                                                            MALE</option>
                                                        <option value="FEMALE"
                                                            {{ old('sex', $applied_applicant->sex) == 'FEMALE' ? 'selected' : '' }}>
                                                            FEMALE</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Marital
                                                    Status</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control required" id="marital_status"
                                                        name="marital_status">
                                                        <option value="">Choose option</option>
                                                        <option value="SINGLE"
                                                            {{ old('marital_status', $applied_applicant->marital_status) == 'SINGLE' ? 'selected' : '' }}>
                                                            SINGLE</option>
                                                        <option value="MARRIED"
                                                            {{ old('marital_status', $applied_applicant->marital_status) == 'MARRIED' ? 'selected' : '' }}>
                                                            MARRIED</option>
                                                        <option value="DIVORSED"
                                                            {{ old('marital_status', $applied_applicant->marital_status) == 'DIVORSED' ? 'selected' : '' }}>
                                                            DIVORSED</option>
                                                    </select>
                                                </div>
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Height
                                                    (Feet/Inches)</label>
                                                <div class="col-sm-2">
                                                    <select id="height" name="height" class="form-control required">
                                                        <option value="">Select</option>
                                                        @for ($i = 5; $i <= 7; $i++)
                                                            @for ($j = 0; $j <= 11; $j++)
                                                                @php
                                                                    $value = number_format($i + $j / 12, 1);
                                                                @endphp
                                                                <option value="{{ $value }}"
                                                                    {{ old('height', number_format((float) $applied_applicant->height, 1)) == $value ? 'selected' : '' }}>
                                                                    {{ $value }}
                                                                </option>
                                                            @endfor
                                                        @endfor
                                                    </select>

                                                </div>
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Weight
                                                    (Kg)</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="weight"
                                                        name="weight"
                                                        value="{{ old('weight', $applied_applicant->weight) }}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Place of
                                                    Birth</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" class="required"
                                                        id="place_of_birth" placeholder="" name="place_of_birth"
                                                        value="{{ old('place_of_birth', $applied_applicant->place_of_birth) }}">
                                                </div>
                                                <label for="b-t-name" class="col-sm-2 col-form-label">National
                                                    ID (Ghana Card)</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" class="required"
                                                        id="national_identity_card" placeholder=""
                                                        name="national_identity_card"
                                                        value="{{ old('national_identity_card', $applied_applicant->national_identity_card) }}">
                                                </div>
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Date
                                                    of
                                                    Birth</label>
                                                <div class="col-sm-2">
                                                    <div class="form-group fill">
                                                        <input type="date" class="form-control" id="date_of_birth"
                                                            name="date_of_birth"
                                                            value="{{ old('date_of_birth', $applied_applicant->date_of_birth) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Hometown</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control required" id="hometown"
                                                        name="hometown"
                                                        value="{{ old('hometown', $applied_applicant->hometown) }}">
                                                </div>
                                                <label for="district" class="col-sm-2 col-form-label">District</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control required" id="district" name="district">
                                                        <option value="">Select District</option>
                                                        @foreach ($districts as $district)
                                                            <option value="{{ $district->id }}"
                                                                {{ old('district', $applied_applicant->district) == $district->id ? 'selected' : '' }}>
                                                                {{ $district->district_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label for="region" class="col-sm-2 col-form-label">Home
                                                    Region</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control required" id="region" name="region">
                                                        <option value="">Select Region</option>
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region->id }}"
                                                                {{ old('region', $applied_applicant->region) == $region->id ? 'selected' : '' }}>
                                                                {{ $region->region_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Telephone
                                                    Number</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control required" id="contact"
                                                        name="contact"
                                                        value="{{ old('contact', $applied_applicant->contact) }}">
                                                </div>
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Email
                                                    Address</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control required" id="email"
                                                        name="email"
                                                        value="{{ old('email', $applied_applicant->email) }}">
                                                </div>

                                                <label for="b-t-name" class="col-sm-2 col-form-label">
                                                    Employment Status</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control required" id="employment"
                                                        name="employment">
                                                        <option value="">Choose option</option>
                                                        <option value="EMPLOYED"
                                                            {{ old('employment', $applied_applicant->employment) == 'EMPLOYED' ? 'selected' : '' }}>
                                                            EMPLOYED</option>
                                                        <option value="UNEMPLOYED"
                                                            {{ old('employment', $applied_applicant->employment) == 'UNEMPLOYED' ? 'selected' : '' }}>
                                                            UNEMPLOYED</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Residential
                                                    Address</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="residential_address"
                                                        name="residential_address"
                                                        value="{{ old('residential_address', $applied_applicant->residential_address) }}">

                                                </div>
                                                <label for="b-t-name" class="col-sm-2 col-form-label">Digital
                                                    Address</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="digital_address"
                                                        name="digital_address"
                                                        value="{{ old('digital_address', $applied_applicant->digital_address) }}">
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <label for="languages" class="col-sm-2 col-form-label">Language(s)
                                                        Spoken</label>
                                                    <div class="col-sm-10">
                                                        @foreach ($ghanaian_languages as $language)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="language_{{ $loop->index }}" name="language[]"
                                                                    value="{{ $language }}"
                                                                    {{ in_array($language, old('language', $applied_applicant->language ?? [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="language_{{ $loop->index }}">{{ $language }}</label>
                                                            </div>
                                                        @endforeach
                                                        @error('language')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="sports_interest" class="col-sm-2 col-form-label">Sporting
                                                        Interest</label>
                                                    <div class="col-sm-10">
                                                        @foreach ($sports_interests as $interest)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="sports_interest_{{ $loop->index }}"
                                                                    name="sports_interest[]" value="{{ $interest }}"
                                                                    {{ in_array($interest, old('sports_interest', $applied_applicant->sports_interest ?? [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="sports_interest_{{ $loop->index }}">{{ $interest }}</label>
                                                            </div>
                                                        @endforeach
                                                        @error('sports_interest')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="mt-5">Basic Education details</h5>
                                            <hr>
                                            <div style="">
                                                <div class="form-group row">
                                                    <label for="b-t-name" class="col-sm-3 col-form-label">BECE
                                                        Index Number</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control required"
                                                            id="bece_index_number" name="bece_index_number"
                                                            value="{{ old('bece_index_number', $applied_applicant->bece_index_number) }}">
                                                    </div>
                                                    <label for="b-t-name" class="col-sm-3 col-form-label">JHS
                                                        Completion Year</label>
                                                    <div class="col-sm-3">
                                                        <div class="form-group fill">
                                                            <input type="date" class="form-control"
                                                                id="bece_year_completion" name="bece_year_completion"
                                                                value="{{ old('bece_year_completion', $applied_applicant->bece_year_completion) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="b-t-name" class="col-sm-3 col-form-label">Upload
                                                        JHS
                                                        Certificate</label>
                                                    <div class="col-sm-3">
                                                        <div
                                                            class="file btn waves-effect waves-light btn-outline-primary mt-3 file-btn">
                                                            <i class="feather icon-paperclip"></i>
                                                            Attachment Document
                                                            {{-- <input type="file" name="bece_certificate" accept=".pdf"
                                                                id="bece_certificate" /> --}}
                                                        </div>

                                                        <div id="file-preview" class="mt-2">
                                                            @if ($applied_applicant->bece_certificate)
                                                                <p>Selected file:
                                                                    {{ pathinfo($applied_applicant->bece_certificate, PATHINFO_FILENAME) }}.{{ pathinfo($applied_applicant->bece_certificate, PATHINFO_EXTENSION) }}
                                                                </p>
                                                                <a href="{{ asset($applied_applicant->bece_certificate) }}"
                                                                    target="_blank">View PDF</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="mt-5">Secondary Education Details</h5>
                                            <hr>
                                            <div style="">
                                                <div class="form-group row">
                                                    <label for="b-t-name" class="col-sm-3 col-form-label">WASSCE
                                                        Index
                                                        Number(s)</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control required"
                                                            id="wassce_index_number" name="wassce_index_number"
                                                            value="{{ old('wassce_index_number', $applied_applicant->wassce_index_number) }}">
                                                    </div>
                                                    <label for="b-t-name" class="col-sm-3 col-form-label">SHS
                                                        Completion Year</label>
                                                    <div class="col-sm-3">
                                                        <input class="form-control datepicker required"
                                                            id="wassce_year_completion" name="wassce_year_completion"
                                                            type="date"
                                                            value="{{ old('wassce_year_completion', $applied_applicant->wassce_year_completion) }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="b-t-name" class="col-sm-3 col-form-label">WASSCE
                                                        Results Slip
                                                        Number(s)</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control required"
                                                            id="wassce_serial_number" name="wassce_serial_number"
                                                            value="{{ old('wassce_serial_number', $applied_applicant->wassce_serial_number) }}">
                                                    </div>

                                                    <label for="b-t-name" class="col-sm-3 col-form-label">Course
                                                        Offerred</label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control required"
                                                            id="secondary_course_offered" name="secondary_course_offered">
                                                            <option value="">Choose Course</option>
                                                            <option value="GENERAL ARTS"
                                                                {{ old('secondary_course_offered', $applied_applicant->secondary_course_offered) == 'GENERAL ARTS' ? 'selected' : '' }}>
                                                                GENERAL ARTS</option>
                                                            <option value="VISUAL ARTS"
                                                                {{ old('secondary_course_offered', $applied_applicant->secondary_course_offered) == 'VISUAL ARTS' ? 'selected' : '' }}>
                                                                VISUAL ARTS</option>
                                                            <option value="BUSINESS"
                                                                {{ old('secondary_course_offered', $applied_applicant->secondary_course_offered) == 'BUSINESS' ? 'selected' : '' }}>
                                                                BUSINESS</option>
                                                            <option value="SCIENCE"
                                                                {{ old('secondary_course_offered', $applied_applicant->secondary_course_offered) == 'SCIENCE' ? 'selected' : '' }}>
                                                                SCIENCE</option>
                                                            <option value="HOME ECONOMICS"
                                                                {{ old('secondary_course_offered', $applied_applicant->secondary_course_offered) == 'HOME ECONOMICS' ? 'selected' : '' }}>
                                                                HOME ECONOMICS</option>
                                                            <option value="VOCATIONAL SKILL"
                                                                {{ old('secondary_course_offered', $applied_applicant->secondary_course_offered) == 'VOCATIONAL SKILL' ? 'selected' : '' }}>
                                                                VOCATIONAL SKILL</option>
                                                            <option value="AGRICULTURAL SCIENCE"
                                                                {{ old('secondary_course_offered', $applied_applicant->secondary_course_offered) == 'AGRICULTURAL SCIENCE' ? 'selected' : '' }}>
                                                                AGRICULTURAL SCIENCE</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="form-group row">

                                                    <label for="b-t-name" class="col-sm-3 col-form-label">Name
                                                        of SHS</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control required"
                                                            id="name_of_secondary_school" name="name_of_secondary_school"
                                                            value="{{ old('name_of_secondary_school', $applied_applicant->name_of_secondary_school) }}">
                                                    </div>
                                                    <label for="b-t-name" class="col-sm-3 col-form-label">Upload
                                                        SHS
                                                        Certificate</label>
                                                    <div class="col-sm-3">
                                                        <div
                                                            class="file btn waves-effect waves-light btn-outline-primary mt-3 file-btn">
                                                            <i class="feather icon-paperclip"></i>
                                                            Attachment Document
                                                            {{-- <input type="file" name="wassce_certificate"
                                                                accept=".pdf" id="wassce_certificate" /> --}}
                                                        </div>
                                                        <div id="wassce-file-preview" class="mt-2">
                                                            @if (!empty($applied_applicant->wassce_certificate))
                                                                <p>Selected file:
                                                                    {{ basename($applied_applicant->wassce_certificate) }}
                                                                </p>
                                                                <a href="{{ asset($applied_applicant->wassce_certificate) }}"
                                                                    target="_blank">View PDF</a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>

                                        <div class="col-md-4">
                                            <h5 class="mt-5">Select Best Six (6) BECE Grades</h5>
                                            <hr>
                                            <div style="text-align: right; margin-left:0.5cm">
                                                <!-- BECE English -->
                                                <div class="form-group row">
                                                    <select id="bece_english" name="bece_english"
                                                        class="col-sm-6 required">
                                                        <option value="ENGLISH LANGUAGE"
                                                            {{ old('bece_english', $applied_applicant->bece_english) == 'ENGLISH LANGUAGE' ? 'selected' : '' }}>
                                                            ENGLISH LANGUAGE
                                                        </option>
                                                    </select>

                                                    <div class="col-sm-3">
                                                        <select id="bece_subject_english_grade"
                                                            name="bece_subject_english_grade"
                                                            class="form-control required">
                                                            <option value="">Select Grade</option>
                                                            @foreach ($bece_results as $grade)
                                                                <option
                                                                    value="{{ $grade->beceresults }}"{{ old('bece_subject_english_grade', $applied_applicant->bece_subject_english_grade) == $grade->beceresults ? 'selected' : '' }}>
                                                                    {{ $grade->beceresults }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- BECE Maths -->
                                                <div class="form-group row">
                                                    <select id="bece_mathematics" name="bece_mathematics"
                                                        class="col-sm-6 required">
                                                        <option value="MATHEMATICS"
                                                            {{ old('bece_mathematics', $applied_applicant->bece_mathematics) == 'MATHEMATICS' ? 'selected' : '' }}>
                                                            MATHEMATICS
                                                        </option>
                                                    </select>

                                                    <div class="col-sm-3">
                                                        <select id="bece_subject_maths_grade"
                                                            name="bece_subject_maths_grade" class="form-control required">
                                                            <option value="">Select Grade</option>
                                                            @foreach ($bece_results as $grade)
                                                                <option value="{{ $grade->beceresults }}"
                                                                    {{ old('bece_subject_maths_grade', $applied_applicant->bece_subject_maths_grade) == $grade->beceresults ? 'selected' : '' }}>
                                                                    {{ $grade->beceresults }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- BECE Subject 1 -->
                                                <div class="form-group row">
                                                    <select id="bece_subject_three"
                                                        name="bece_subject_three"class="col-sm-6 required">
                                                        <option value="" selected="selected">Select
                                                            Subject</option>
                                                        @foreach ($bece_subject as $subject)
                                                            <option value="{{ $subject->becesubjects }}"
                                                                {{ old('bece_subject_three', $applied_applicant->bece_subject_three) == $subject->becesubjects ? 'selected' : '' }}>
                                                                {{ $subject->becesubjects }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="col-sm-3">
                                                        <select id="bece_subject_three_grade"
                                                            name="bece_subject_three_grade" class="form-control required">
                                                            <option value="">Select Grade</option>
                                                            @foreach ($bece_results as $grade)
                                                                <option
                                                                    value="{{ $grade->beceresults }}"{{ old('bece_subject_three_grade', $applied_applicant->bece_subject_three_grade) == $grade->beceresults ? 'selected' : '' }}>
                                                                    {{ $grade->beceresults }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- BECE Subject 2 -->
                                                <div class="form-group row">
                                                    <select id="bece_subject_four" name="bece_subject_four"
                                                        class="col-sm-6 required">
                                                        <option value="" selected="selected">Select
                                                            Subject</option>
                                                        @foreach ($bece_subject as $subject)
                                                            <option value="{{ $subject->becesubjects }}"
                                                                {{ old('bece_subject_four', $applied_applicant->bece_subject_four) == $subject->becesubjects ? 'selected' : '' }}>
                                                                {{ $subject->becesubjects }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="col-sm-3">
                                                        <select id="bece_subject_four_grade"
                                                            name="bece_subject_four_grade" class="form-control required">
                                                            <option value="">Select Grade</option>
                                                            @foreach ($bece_results as $grade)
                                                                <option value="{{ $grade->beceresults }}"
                                                                    {{ old('bece_subject_four_grade', $applied_applicant->bece_subject_four_grade) == $grade->beceresults ? 'selected' : '' }}>
                                                                    {{ $grade->beceresults }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- BECE Subject 3 -->
                                                <div class="form-group row">
                                                    <select id="bece_subject_five" name="bece_subject_five"
                                                        class="col-sm-6 required">
                                                        <option value="" selected="selected">Select
                                                            Subject</option>
                                                        @foreach ($bece_subject as $subject)
                                                            <option value="{{ $subject->becesubjects }}"
                                                                {{ old('bece_subject_five', $applied_applicant->bece_subject_five) == $subject->becesubjects ? 'selected' : '' }}>
                                                                {{ $subject->becesubjects }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="col-sm-3">
                                                        <select id="bece_subject_five_grade"
                                                            name="bece_subject_five_grade" class="form-control required">
                                                            <option value="">Select Grade</option>
                                                            @foreach ($bece_results as $grade)
                                                                <option value="{{ $grade->beceresults }}"
                                                                    {{ old('bece_subject_five_grade', $applied_applicant->bece_subject_five_grade) == $grade->beceresults ? 'selected' : '' }}>
                                                                    {{ $grade->beceresults }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- BECE Subject 4 -->
                                                <div class="form-group row">
                                                    <select id="bece_subject_six" name="bece_subject_six"
                                                        class="col-sm-6 required">
                                                        <option value="" selected="selected">Select
                                                            Subject</option>
                                                        @foreach ($bece_subject as $subject)
                                                            <option value="{{ $subject->becesubjects }}"
                                                                {{ old('bece_subject_six', $applied_applicant->bece_subject_six) == $subject->becesubjects ? 'selected' : '' }}>
                                                                {{ $subject->becesubjects }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="col-sm-3">
                                                        <select id="bece_subject_six_grade" name="bece_subject_six_grade"
                                                            class="form-control required">
                                                            <option value="">Select Grade</option>
                                                            @foreach ($bece_results as $grade)
                                                                <option value="{{ $grade->beceresults }}"
                                                                    {{ old('bece_subject_six_grade', $applied_applicant->bece_subject_six_grade) == $grade->beceresults ? 'selected' : '' }}>
                                                                    {{ $grade->beceresults }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <h5 class="mt-5">Select Best Six (6) WASSCE Grades</h5>
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <select id="exam_type_one" name="exam_type_one"
                                                        class="form-control required">
                                                        <option value="" selected="selected">Select
                                                            Exam
                                                            Type</option>
                                                        <option value="WASSCE"
                                                            {{ old('exam_type_one', $applied_applicant->exam_type_one) == 'WASSCE' ? 'selected' : '' }}>
                                                            WASSCE</option>
                                                        <option value="PRIVATE"
                                                            {{ old('exam_type_one', $applied_applicant->exam_type_one) == 'PRIVATE' ? 'selected' : '' }}>
                                                            PRIVATE</option>
                                                        <option value="A LEVEL"
                                                            {{ old('exam_type_one', $applied_applicant->exam_type_one) == 'A LEVEL' ? 'selected' : '' }}>
                                                            A LEVEL</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_english" name="wassce_english"
                                                        class="form-control required">
                                                        <option value="ENGLISH LANGUAGE"
                                                            {{ old('wassce_english', $applied_applicant->wassce_english) == 'ENGLISH LANGUAGE' ? 'selected' : '' }}>
                                                            ENGLISH LANGUAGE</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_english_grade"
                                                        name="wassce_subject_english_grade" class="form-control required">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($wassce_results as $grade)
                                                            <option value="{{ $grade->wassceresult }}"
                                                                {{ old('wassce_subject_english_grade', $applied_applicant->wassce_subject_english_grade) == $grade->wassceresult ? 'selected' : '' }}>
                                                                {{ $grade->wassceresult }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="results_slip_one" name="results_slip_one"
                                                        class="form-control"
                                                        value="{{ old('results_slip_one', $applied_applicant->results_slip_one) }}"
                                                        placeholder="Results Slip Number(s)">
                                                    <input type="checkbox" id="check_same" name="check_same"
                                                        class="ml-2"> Same as above
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <select id="exam_type_two" name="exam_type_two"
                                                        class="form-control required">
                                                        <option value="" selected="selected">Select
                                                            Exam
                                                            Type</option>
                                                        <option value="WASSCE"
                                                            {{ old('exam_type_two', $applied_applicant->exam_type_two) == 'WASSCE' ? 'selected' : '' }}>
                                                            WASSCE</option>
                                                        <option value="PRIVATE"
                                                            {{ old('exam_type_two', $applied_applicant->exam_type_two) == 'PRIVATE' ? 'selected' : '' }}>
                                                            PRIVATE</option>
                                                        <option value="A LEVEL"
                                                            {{ old('exam_type_two', $applied_applicant->exam_type_two) == 'A LEVEL' ? 'selected' : '' }}>
                                                            A LEVEL</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_mathematics" name="wassce_mathematics"
                                                        class="form-control required">
                                                        <option value="CORE MATHEMATICS"
                                                            {{ old('wassce_mathematics', $applied_applicant->wassce_mathematics) == 'CORE MATHEMATICS' ? 'selected' : '' }}>
                                                            CORE MATHEMATICS
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_maths_grade"
                                                        name="wassce_subject_maths_grade" class="form-control required">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($wassce_results as $grade)
                                                            <option value="{{ $grade->wassceresult }}"
                                                                {{ old('wassce_subject_maths_grade', $applied_applicant->wassce_subject_maths_grade) == $grade->wassceresult ? 'selected' : '' }}>
                                                                {{ $grade->wassceresult }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="results_slip_two" id="results_slip_two"
                                                        name="results_slip_two" class="form-control"
                                                        value="{{ old('results_slip_two', $applied_applicant->results_slip_two) }}"
                                                        placeholder="Results Slip Number(s)">

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <select id="exam_type_three" name="exam_type_three"
                                                        class="form-control required">
                                                        <option value="" selected="selected">Select
                                                            Exam
                                                            Type</option>
                                                        <option value="WASSCE"
                                                            {{ old('exam_type_three', $applied_applicant->exam_type_three) == 'WASSCE' ? 'selected' : '' }}>
                                                            WASSCE</option>
                                                        <option value="PRIVATE"
                                                            {{ old('exam_type_three', $applied_applicant->exam_type_three) == 'PRIVATE' ? 'selected' : '' }}>
                                                            PRIVATE</option>
                                                        <option value="A LEVEL"
                                                            {{ old('exam_type_three', $applied_applicant->exam_type_three) == 'A LEVEL' ? 'selected' : '' }}>
                                                            A LEVEL</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_three" name="wassce_subject_three"
                                                        class="form-control required">
                                                        <option value="">Select Subject</option>
                                                        @foreach ($wassce_subject as $subject)
                                                            <option value="{{ $subject->wasscesubjects }}"
                                                                {{ old('wassce_subject_three', $applied_applicant->wassce_subject_three) == $subject->wasscesubjects ? 'selected' : '' }}>
                                                                {{ $subject->wasscesubjects }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_three_grade"
                                                        name="wassce_subject_three_grade" class="form-control required">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($wassce_results as $grade)
                                                            <option value="{{ $grade->wassceresult }}"
                                                                {{ old('wassce_subject_three_grade', $applied_applicant->wassce_subject_three_grade) == $grade->wassceresult ? 'selected' : '' }}>
                                                                {{ $grade->wassceresult }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="results_slip_three"
                                                        name="results_slip_three" class="form-control"
                                                        value="{{ old('results_slip_three', $applied_applicant->results_slip_three) }}"
                                                        placeholder="Results Slip Number(s)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <select id="exam_type_four" name="exam_type_four"
                                                        class="form-control required">
                                                        <option value="" selected="selected">Select
                                                            Exam
                                                            Type</option>
                                                        <option value="WASSCE"
                                                            {{ old('exam_type_four', $applied_applicant->exam_type_four) == 'WASSCE' ? 'selected' : '' }}>
                                                            WASSCE</option>
                                                        <option value="PRIVATE"
                                                            {{ old('exam_type_four', $applied_applicant->exam_type_four) == 'PRIVATE' ? 'selected' : '' }}>
                                                            PRIVATE</option>
                                                        <option value="A LEVEL"
                                                            {{ old('exam_type_four', $applied_applicant->exam_type_four) == 'A LEVEL' ? 'selected' : '' }}>
                                                            A LEVEL</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_four" name="wassce_subject_four"
                                                        class="form-control required">
                                                        <option value="">Select Subject</option>
                                                        @foreach ($wassce_subject as $subject)
                                                            <option value="{{ $subject->wasscesubjects }}"
                                                                {{ old('wassce_subject_four', $applied_applicant->wassce_subject_four) == $subject->wasscesubjects ? 'selected' : '' }}>
                                                                {{ $subject->wasscesubjects }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_four_grade"
                                                        name="wassce_subject_four_grade" class="form-control required">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($wassce_results as $grade)
                                                            <option value="{{ $grade->wassceresult }}"
                                                                {{ old('wassce_subject_four_grade', $applied_applicant->wassce_subject_four_grade) == $grade->wassceresult ? 'selected' : '' }}>
                                                                {{ $grade->wassceresult }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="results_slip_four" name="results_slip_four"
                                                        class="form-control"
                                                        value="{{ old('results_slip_four', $applied_applicant->results_slip_four) }}"
                                                        placeholder="Results Slip Number(s)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <select id="exam_type_five" name="exam_type_five"
                                                        class="form-control required">
                                                        <option value="" selected="selected">Select
                                                            Exam
                                                            Type</option>
                                                        <option value="WASSCE"
                                                            {{ old('exam_type_five', $applied_applicant->exam_type_five) == 'WASSCE' ? 'selected' : '' }}>
                                                            WASSCE</option>
                                                        <option value="PRIVATE"
                                                            {{ old('exam_type_five', $applied_applicant->exam_type_five) == 'PRIVATE' ? 'selected' : '' }}>
                                                            PRIVATE</option>
                                                        <option value="A LEVEL"
                                                            {{ old('exam_type_five', $applied_applicant->exam_type_five) == 'A LEVEL' ? 'selected' : '' }}>
                                                            A LEVEL</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_five" name="wassce_subject_five"
                                                        class="form-control required">
                                                        <option value="">Select Subject</option>
                                                        @foreach ($wassce_subject as $subject)
                                                            <option value="{{ $subject->wasscesubjects }}"
                                                                {{ old('wassce_subject_five', $applied_applicant->wassce_subject_five) == $subject->wasscesubjects ? 'selected' : '' }}>
                                                                {{ $subject->wasscesubjects }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_five_grade"
                                                        name="wassce_subject_five_grade" class="form-control required">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($wassce_results as $grade)
                                                            <option value="{{ $grade->wassceresult }}"
                                                                {{ old('wassce_subject_five_grade', $applied_applicant->wassce_subject_five_grade) == $grade->wassceresult ? 'selected' : '' }}>
                                                                {{ $grade->wassceresult }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="results_slip_five" name="results_slip_five"
                                                        class="form-control"
                                                        value="{{ old('results_slip_five', $applied_applicant->results_slip_five) }}"
                                                        placeholder="Results Slip Number(s)">

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <select id="exam_type_six" name="exam_type_six"
                                                        class="form-control required">
                                                        <option value="" selected="selected">Select
                                                            Exam
                                                            Type</option>
                                                        <option value="WASSCE"
                                                            {{ old('exam_type_six', $applied_applicant->exam_type_six) == 'WASSCE' ? 'selected' : '' }}>
                                                            WASSCE</option>
                                                        <option value="PRIVATE"
                                                            {{ old('exam_type_six', $applied_applicant->exam_type_six) == 'PRIVATE' ? 'selected' : '' }}>
                                                            PRIVATE</option>
                                                        <option value="A LEVEL"
                                                            {{ old('exam_type_six', $applied_applicant->exam_type_six) == 'A LEVEL' ? 'selected' : '' }}>
                                                            A LEVEL</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_six" name="wassce_subject_six"
                                                        class="form-control required">
                                                        <option value="">Select Subject</option>
                                                        @foreach ($wassce_subject as $subject)
                                                            <option value="{{ $subject->wasscesubjects }}"
                                                                {{ old('wassce_subject_six', $applied_applicant->wassce_subject_six) == $subject->wasscesubjects ? 'selected' : '' }}>
                                                                {{ $subject->wasscesubjects }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select id="wassce_subject_six_grade" name="wassce_subject_six_grade"
                                                        class="form-control required">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($wassce_results as $grade)
                                                            <option value="{{ $grade->wassceresult }}"
                                                                {{ old('wassce_subject_six_grade', $applied_applicant->wassce_subject_six_grade) == $grade->wassceresult ? 'selected' : '' }}>
                                                                {{ $grade->wassceresult }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" id="results_slip_six" name="results_slip_six"
                                                        class="form-control"
                                                        value="{{ old('results_slip_six', $applied_applicant->results_slip_six) }}"
                                                        placeholder="Results Slip Number(s)">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <h5 class="mt-12">Tertiary Education details</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="b-t-name" class="col-sm-2 col-form-label">Name
                                                            of Institution</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control required"
                                                                id="name_of_tertiary" name="name_of_tertiary"
                                                                value="{{ old('name_of_tertiary', $applied_applicant->name_of_tertiary) }}">
                                                        </div>
                                                        <label for="b-t-name"
                                                            class="col-sm-2 col-form-label">Qualification</label>
                                                        <div class="col-sm-2">
                                                            <select id="tertiary_qualification"
                                                                name="tertiary_qualification"
                                                                class="form-control required">
                                                                <option value="BSc."
                                                                    {{ old('tertiary_qualification', $applied_applicant->tertiary_qualification) == 'BSc.' ? 'selected' : '' }}>
                                                                    BSc.
                                                                </option>
                                                                <option value="BA."
                                                                    {{ old('tertiary_qualification', $applied_applicant->tertiary_qualification) == 'BA.' ? 'selected' : '' }}>
                                                                    BA.
                                                                </option>
                                                                <option value="BEng."
                                                                    {{ old('tertiary_qualification', $applied_applicant->tertiary_qualification) == 'BEng.' ? 'selected' : '' }}>
                                                                    BEng.
                                                                </option>
                                                                <option value="LLB."
                                                                    {{ old('tertiary_qualification', $applied_applicant->tertiary_qualification) == 'LLB.' ? 'selected' : '' }}>
                                                                    LLB.
                                                                </option>

                                                            </select>

                                                        </div>
                                                        <div class="col-sm-3">
                                                            <select id="programme" name="programme"
                                                                class="form-control required">
                                                                <option value="">CHOOSE PROGRAMME
                                                                </option>
                                                                <option value="COMPUTER SCIENCE"
                                                                    {{ old('programme', $applied_applicant->programme) == 'COMPUTER SCIENCE' ? 'selected' : '' }}>
                                                                    COMPUTER SCIENCE
                                                                </option>
                                                                <option value="BUSINESS ADMINISTRATION"
                                                                    {{ old('programme', $applied_applicant->programme) == 'BUSINESS ADMINISTRATION' ? 'selected' : '' }}>
                                                                    BUSINESS ADMINISTRATION
                                                                </option>
                                                                <option value="MECHANICAL ENGINEERING"
                                                                    {{ old('programme', $applied_applicant->programme) == 'MECHANICAL ENGINEERING' ? 'selected' : '' }}>
                                                                    MECHANICAL ENGINEERING
                                                                </option>
                                                                <option value="ELECTRICAL ENGINEERING"
                                                                    {{ old('programme', $applied_applicant->programme) == 'ELECTRICAL ENGINEERING' ? 'selected' : '' }}>
                                                                    ELECTRICAL ENGINEERING
                                                                </option>
                                                                <option value="CIVIL ENGINEERING"
                                                                    {{ old('programme', $applied_applicant->programme) == 'CIVIL ENGINEERING' ? 'selected' : '' }}>
                                                                    CIVIL ENGINEERING
                                                                </option>
                                                                <option value="LAW"
                                                                    {{ old('programme', $applied_applicant->programme) == 'LAW' ? 'selected' : '' }}>
                                                                    LAW
                                                                </option>
                                                                <option value="MEDICINE"
                                                                    {{ old('programme', $applied_applicant->programme) == 'MEDICINE' ? 'selected' : '' }}>
                                                                    MEDICINE
                                                                </option>
                                                                <option value="PHARMACY"
                                                                    {{ old('programme', $applied_applicant->programme) == 'PHARMACY' ? 'selected' : '' }}>
                                                                    PHARMACY
                                                                </option>
                                                                <option value="NURSING"
                                                                    {{ old('programme', $applied_applicant->programme) == 'NURSING' ? 'selected' : '' }}>
                                                                    NURSING
                                                                </option>
                                                                <option value="ARCHITECTURE"
                                                                    {{ old('programme', $applied_applicant->programme) == 'ARCHITECTURE' ? 'selected' : '' }}>
                                                                    ARCHITECTURE
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="b-t-name" class="col-sm-3 col-form-label">Class
                                                            Attained</label>
                                                        <div class="col-sm-3">
                                                            <select id="class_attained" name="class_attained"
                                                                class="form-control required">
                                                                <option value="">Choose option
                                                                </option>
                                                                <option value="FIRST CLASS"
                                                                    {{ old('class_attained', $applied_applicant->class_attained) == 'FIRST CLASS' ? 'selected' : '' }}>
                                                                    FIRST CLASS</option>
                                                                <option value="SECOND CLASS (UPPER DIVISION)"
                                                                    {{ old('class_attained', $applied_applicant->class_attained) == 'SECOND CLASS (UPPER DIVISION)' ? 'selected' : '' }}>
                                                                    SECOND CLASS (UPPER DIVISION)</option>
                                                                <option value="SECOND CLASS (LOWER DIVISION)"
                                                                    {{ old('class_attained', $applied_applicant->class_attained) == 'SECOND CLASS (LOWER DIVISION)' ? 'selected' : '' }}>
                                                                    SECOND CLASS (LOWER DIVISION)</option>

                                                            </select>
                                                        </div>
                                                        <label for="b-t-name" class="col-sm-3 col-form-label">Year
                                                            of Completion</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" id="higherCompletion"
                                                                name="year_of_completion" class="form-control required"
                                                                value="{{ old('year_of_completion', $applied_applicant->year_of_completion) }}">
                                                        </div>
                                                        <label for="b-t-name" class="col-sm-2 col-form-label">Upload
                                                            Certificate</label>
                                                        <div class="col-sm-3">
                                                            <div
                                                                class="file btn waves-effect waves-light btn-outline-primary mt-3 file-btn">
                                                                <i class="feather icon-paperclip"></i>
                                                                Attachment Document
                                                                {{-- <input type="file" id="degree_certificate"
                                                                    accept=".pdf" name="degree_certificate" /> --}}
                                                            </div>
                                                            <div id="degree-file-preview" class="mt-2">
                                                                @if (!empty($applied_applicant->degree_certificate))
                                                                    <p>Selected file:
                                                                        {{ basename($applied_applicant->degree_certificate) }}
                                                                    </p>
                                                                    <a href="{{ asset($applied_applicant->degree_certificate) }}"
                                                                        target="_blank">View PDF</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @if ($applied_applicant->commission_type === 'SHORT SERVICE')
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h5 class="mt-12" style="text-align: left">Professional
                                                    Qualification
                                                    details</h5>
                                                <hr>
                                                <div style="">
                                                    <div class="form-group row">
                                                        <label for="b-t-name" class="col-sm-2 col-form-label">Name
                                                            of
                                                            Institution</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control required"
                                                                id="name_of_professional_school"
                                                                name="name_of_professional_school"
                                                                value="{{ old('name_of_professional_school', $applied_applicant->name_of_professional_school) }}">
                                                        </div>
                                                        <label for="b-t-name"
                                                            class="col-sm-2 col-form-label">Programme</label>
                                                        <div class="col-sm-1">
                                                            <select id="professional_programme"
                                                                name="professional_programme"
                                                                class="form-control required">
                                                                <option value="">Select Option</option>
                                                                <option
                                                                    value="MBChB."{{ old('professional_programme', $applied_applicant->professional_programme) == 'MBChB.' ? 'selected' : '' }}>
                                                                    MBChB.
                                                                </option>
                                                                <option value="MSc."
                                                                    {{ old('professional_programme', $applied_applicant->professional_programme) == 'MSc.' ? 'selected' : '' }}>
                                                                    MSc.
                                                                </option>
                                                                <option value="MA."
                                                                    {{ old('professional_programme', $applied_applicant->professional_programme) == 'MA.' ? 'selected' : '' }}>
                                                                    MA.
                                                                </option>
                                                                <option value="MEng."
                                                                    {{ old('professional_programme', $applied_applicant->professional_programme) == 'MEng.' ? 'selected' : '' }}>
                                                                    MEng.
                                                                </option>
                                                                <option value="PhD."
                                                                    {{ old('professional_programme', $applied_applicant->professional_programme) == 'PhD.' ? 'selected' : '' }}>
                                                                    PhD.
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <select id="professional_qualification"
                                                                name="professional_qualification"
                                                                class="form-control required">
                                                                <option value="">CHOOSE
                                                                    professional_qualification
                                                                </option>
                                                                <option value="COMPUTER SCIENCE"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'COMPUTER SCIENCE' ? 'selected' : '' }}>
                                                                    COMPUTER SCIENCE
                                                                </option>
                                                                <option value="BUSINESS ADMINISTRATION"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'BUSINESS ADMINISTRATION' ? 'selected' : '' }}>
                                                                    BUSINESS ADMINISTRATION
                                                                </option>
                                                                <option value="MECHANICAL ENGINEERING"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'MECHANICAL ENGINEERING' ? 'selected' : '' }}>
                                                                    MECHANICAL ENGINEERING
                                                                </option>
                                                                <option value="ELECTRICAL ENGINEERING"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'ELECTRICAL ENGINEERING' ? 'selected' : '' }}>
                                                                    ELECTRICAL ENGINEERING
                                                                </option>
                                                                <option value="CIVIL ENGINEERING"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'CIVIL ENGINEERING' ? 'selected' : '' }}>
                                                                    CIVIL ENGINEERING
                                                                </option>
                                                                <option value="LAW"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'LAW' ? 'selected' : '' }}>
                                                                    LAW
                                                                </option>
                                                                <option value="MEDICINE"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'MEDICINE' ? 'selected' : '' }}>
                                                                    MEDICINE
                                                                </option>
                                                                <option value="PHARMACY"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'PHARMACY' ? 'selected' : '' }}>
                                                                    PHARMACY
                                                                </option>
                                                                <option value="NURSING"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'NURSING' ? 'selected' : '' }}>
                                                                    NURSING
                                                                </option>
                                                                <option value="ARCHITECTURE"
                                                                    {{ old('professional_qualification', $applied_applicant->professional_qualification) == 'ARCHITECTURE' ? 'selected' : '' }}>
                                                                    ARCHITECTURE
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <label for="b-t-name" class="col-sm-2 col-form-label">Year
                                                            of
                                                            Completion</label>
                                                        <div class="col-sm-1">
                                                            <input type="date" class="form-control required"
                                                                name="year_of_professional_completion"
                                                                value="{{ old('year_of_professional_completion', $applied_applicant->year_of_professional_completion) }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="b-t-name" class="col-sm-2 col-form-label">Years of
                                                            Experience</label>
                                                        <div class="col-sm-2">
                                                            <select
                                                                id="year_of_professional_experience"name="year_of_professional_experience"
                                                                class="form-control required">
                                                                <option value="">select option</option>
                                                                <option value="1"
                                                                    {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '1' ? 'selected' : '' }}>
                                                                    1
                                                                </option>
                                                                <option value="2"
                                                                    {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '2' ? 'selected' : '' }}>
                                                                    2
                                                                </option>
                                                                <option value="3"
                                                                    {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '3' ? 'selected' : '' }}>
                                                                    3
                                                                </option>
                                                                <option value="4"
                                                                    {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '4' ? 'selected' : '' }}>
                                                                    4
                                                                </option>
                                                                <option value="5 YEARS AND ABOVE"
                                                                    {{ old('year_of_professional_experience', $applied_applicant->year_of_professional_experience) == '5 YEARS AND ABOVEA' ? 'selected' : '' }}>
                                                                    5 YEARS AND ABOVEA
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <label for="b-t-name"
                                                            class="col-sm-2 col-form-label">PIN/AIN/HIN/Certificate
                                                            Number</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control required"
                                                                id="pin_id" name="pin_number"
                                                                value="{{ old('pin_number', $applied_applicant->pin_number) }}">
                                                        </div>
                                                        <label for="b-t-name" class="col-sm-2 col-form-label">Upload
                                                            Certificate</label>
                                                        <div class="col-sm-2">
                                                            <div
                                                                class="file btn waves-effect waves-light btn-outline-primary mt-3 file-btn">
                                                                <i class="feather icon-paperclip"></i>
                                                                Attachment Document
                                                                {{-- <input type="file" name="professional_certificate"
                            accept=".pdf" id="professional_certificate" /> --}}
                                                            </div>
                                                            <div id="professional-file-preview" class="mt-2">
                                                                @if (!empty($applied_applicant->professional_certificate))
                                                                    <p>Selected file:
                                                                        {{ basename($applied_applicant->professional_certificate) }}
                                                                    </p>
                                                                    <a href="{{ asset($applied_applicant->professional_certificate) }}"
                                                                        target="_blank">View PDF</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <button type="submit" class="btn btn-primary save-btn" style="float:right;">Update
                                        Applicant Record</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkSame = document.getElementById('check_same');
            const examTypeOne = document.getElementById('exam_type_one');
            const resultSlipOne = document.getElementById('results_slip_one');
            checkSame.addEventListener('change', function() {
                if (checkSame.checked) {
                    const examTypeValue = examTypeOne.value;
                    const resultSlipValue = resultSlipOne.value;
                    // Copy values to other fields
                    document.getElementById('exam_type_two').value = examTypeValue;
                    document.getElementById('results_slip_two').value = resultSlipValue;

                    document.getElementById('exam_type_three').value = examTypeValue;
                    document.getElementById('results_slip_three').value = resultSlipValue;

                    document.getElementById('exam_type_four').value = examTypeValue;
                    document.getElementById('results_slip_four').value = resultSlipValue;

                    document.getElementById('exam_type_five').value = examTypeValue;
                    document.getElementById('results_slip_five').value = resultSlipValue;

                    document.getElementById('exam_type_six').value = examTypeValue;
                    document.getElementById('results_slip_six').value = resultSlipValue;
                } else {
                    // Optionally clear the copied values when unchecked
                    document.getElementById('exam_type_two').value = '';
                    document.getElementById('results_slip_two').value = '';

                    document.getElementById('exam_type_three').value = '';
                    document.getElementById('results_slip_three').value = '';

                    document.getElementById('exam_type_four').value = '';
                    document.getElementById('results_slip_four').value = '';

                    document.getElementById('exam_type_five').value = '';
                    document.getElementById('results_slip_five').value = '';

                    document.getElementById('exam_type_six').value = '';
                    document.getElementById('results_slip_six').value = '';
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#district').change(function() {
                var district_id = $(this).val();
                if (district_id) {
                    $.ajax({
                        url: '/get-regions/' + district_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#region').empty();
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#region').append('<option value="' + value.id +
                                        '">' + value.region_name + '</option>');
                                });
                            } else {
                                $('#region').append(
                                    '<option value="">No regions available</option>');
                            }
                        }
                    });
                } else {
                    $('#region').empty();
                    $('#region').append('<option value="">Select Region</option>');
                }
            });
        });
    </script>
@endsection
