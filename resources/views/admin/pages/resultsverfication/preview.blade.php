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
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">SELECTED COURSE:
                                {{ $applied_applicant->cause_offers}}</a></li>
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
                        GAFCONM
                    </h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
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
                        <div class="tab-content">
                            <div>
                                <div class="text-center">

                                    <hr>
                                    <h4 class="text-center"
                                        style="font-weight: bolder;text-transform: uppercase; margin-top: 20px; margin-bottom: 20px;">
                                        Applicant Details
                                    </h4>
                                    <hr>
                                    @php
                                        $imagePath = public_path($applied_applicant->applicant_image);
                                    @endphp
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <td>
                                                @if (file_exists($imagePath))
                                                    <img id="showImage"
                                                        src="{{ asset($applied_applicant->applicant_image) }}"
                                                        alt="" width="200px" class="img-thumbnail">
                                                @else
                                                    <img id="showImage"
                                                        src="{{ asset('assets/images/img_placeholder_avatar.jpg') }}"
                                                        alt="" width="200px" class="img-thumbnail">
                                                @endif
                                            </td>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="container">
                                                    <div>
                                                        <h5 style="margin-top: 10px; color:red"><b>
                                                                 COURSE SELECTED:
                                                                {{ $applied_applicant->cause_offers }} / ENTRANCE: {{ $applied_applicant->entrance_type }}


                                                            </b>
                                                        </h5>
                                                        <span></span>
                                                        <h5 class="mt-5"
                                                            style="text-transform: uppercase; text-align:left; margin-left: 0.5cm">
                                                            Biodata details</h5>
                                                        <div class="row"
                                                            style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <th>Surname</th>
                                                                    <th>First Name</th>
                                                                    <th>OtherNames</th>
                                                                    <th>Marital Status</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="preview-surname">
                                                                            {{ $applied_applicant->surname }}
                                                                        </td>
                                                                        <td id="preview-othernames">
                                                                            <b></b>
                                                                            {{ $applied_applicant->first_name }}
                                                                        </td>
                                                                        <td id="preview-sex">
                                                                            <b></b>
                                                                           {{ $applied_applicant->other_names }}
                                                                        </td>
                                                                        <td id="preview-marital-status">
                                                                            <b></b>
                                                                            {{ $applied_applicant->marital_status }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="row"
                                                            style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                     <th>Sex</th>
                                                                    <th>Date of Birth</th>
                                                                    <th>Contact</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                         <td id="preview-sex">
                                                                            <b></b>
                                                                            {{ $applied_applicant->sex }}
                                                                        </td>
                                                                        <td id="preview-date-of-birth">
                                                                            <b></b>
                                                                            {{ \Carbon\Carbon::parse($applied_applicant->date_of_birth)->format('d M, Y') }}
                                                                        </td>
                                                                        <td id="preview-contact">
                                                                            <b></b>
                                                                            {{ $applied_applicant->contact }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row"
                                                            style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <th>Identity Type</th>
                                                                    <th>Card Number</th>
                                                                    <th>Email</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="preview-date-of-birth">
                                                                            <b></b>
                                                                             {{ $applied_applicant->identity_type }}
                                                                        </td>
                                                                        <td id="preview-contact">
                                                                            <b></b>
                                                                            {{ $applied_applicant->national_identity_card }}
                                                                        </td>
                                                                        <td id="preview-email">
                                                                            <b></b>
                                                                            {{ $applied_applicant->email }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="row" style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <th>Residential Address</th>
                                                                    <th>Language(s) Spoken </th>

                                                                    <th>Sssce/Wassce Certifcate</th>

                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="preview-residential-address">
                                                                            <b></b>
                                                                            {{ $applied_applicant->residential_address }}
                                                                        </td>
                                                                        <td id="preview-languages">
                                                                            <b></b>
                                                                            @php
                                                                                $languages = is_string(
                                                                                    $applied_applicant->language,
                                                                                )
                                                                                    ? json_decode(
                                                                                        $applied_applicant->language,
                                                                                        true,
                                                                                    )
                                                                                    : $applied_applicant->language;
                                                                            @endphp
                                                                            {{ implode(', ', $languages ?? []) }}
                                                                        </td>

                                                                        <td id="wassce-file-preview">
                                                                            {{-- @if (!empty($applied_applicant->wassce_certificate))

                                                                            Selected file:
                                                                            <a href="{{ asset($applied_applicant->wassce_certificate) }}"
                                                                                target="_blank">View PDF</a>
                                                                        @endif --}}

                                                                         @if(!empty($applied_applicant->wassce_certificate))
        @foreach(json_decode($applied_applicant->wassce_certificate) as $index => $file)
            <div>
                {{ $index + 1 }}.
                <a href="{{ asset($file) }}" target="_blank">{{ basename($file) }}</a>
            </div>
        @endforeach
    @endif

                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="row" style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <th>Birth Certificate</th>

                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="birth_certificate">
                                                                            @if (!empty($applied_applicant->birth_certificate))

                                                                            Selected file:
                                                                            <a href="{{ asset($applied_applicant->birth_certificate) }}"
                                                                                target="_blank">View PDF</a>
                                                                        @endif
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <h5 class="mt-5"
                                                            style="text-transform: uppercase; text-align:left; margin-left: 0.5cm">
                                                            Educational details</h5>
                                                        <div class="row"
                                                            style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <th>WASSCE Index Number</th>
                                                                    <th>SHS Completion Year</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="wassce_index_number">
                                                                            <b></b>
                                                                            {{ $applied_applicant->wassce_index_number }}
                                                                        </td>
                                                                        <td id="wassce_year_completion">
                                                                            <b></b>
                                                                            {{ \Carbon\Carbon::parse($applied_applicant->wassce_year_completion)->format('d M, Y') }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row"
                                                            style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <th>Results Slip Number</th>
                                                                    <th>School Name</th>
                                                                    <th>Course Offered</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td id="preview-shs-completion-year">
                                                                            <b></b>
                                                                            {{ $applied_applicant->wassce_serial_number }}
                                                                        </td>
                                                                        <td id="preview-shs-name">
                                                                            <b></b>
                                                                            {{ $applied_applicant->name_of_secondary_school }}
                                                                        </td>
                                                                        <td>
                                                                            <b></b>
                                                                            {{ $applied_applicant->secondary_course_offered }}
                                                                        </td>

                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row" style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                            <table class="table table-bordered">
                                                                <thead>

                                                                    <th>Exams Type</th>
                                                                    <th>WASSCE Subjects</th>
                                                                    <th>Grades</th>
                                                                    <th>Result slip Number</th>
                                                                </thead>
                                                                <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <b>
                                                                                            <span id="exam_type_one" class="form-control required">
                                                                                                {{ $applied_applicant->exam_type_one }}
                                                                                            </span>
                                                                                            <span id="exam_type_two" class="form-control required">
                                                                                                {{ $applied_applicant->exam_type_two }}
                                                                                            </span>
                                                                                            <span id="wassce_sub1" class="form-control">
                                                                                                {{ $applied_applicant->exam_type_three }}
                                                                                            </span>
                                                                                            <span id="wassce_sub2" class="form-control">
                                                                                                {{ $applied_applicant->exam_type_four }}
                                                                                            </span>
                                                                                            <span id="wassce_sub3" class="form-control">
                                                                                                {{ $applied_applicant->exam_type_five }}
                                                                                            </span>
                                                                                            <span id="wassce_sub4" class="form-control">
                                                                                                {{ $applied_applicant->exam_type_six }}
                                                                                            </span>
                                                                                        </b>
                                                                                    </td>
                                                                                    <td>
                                                                                        <b>
                                                                                            <span id="wassce_english" class="form-control">
                                                                                                {{ $applied_applicant->wassce_english }}
                                                                                            </span>
                                                                                            <span id="wassce_maths" class="form-control">
                                                                                                {{ $applied_applicant->wassce_mathematics }}
                                                                                            </span>
                                                                                            <span id="wassce_sub1" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_three }}
                                                                                            </span>
                                                                                            <span id="wassce_sub2" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_four }}
                                                                                            </span>
                                                                                            <span id="wassce_sub3" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_five }}
                                                                                            </span>
                                                                                            <span id="wassce_sub4" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_six }}
                                                                                            </span>
                                                                                        </b>
                                                                                    </td>
                                                                                    <td>
                                                                                        <b>
                                                                                            <span id="wassce_english_grade" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_english_grade }}
                                                                                            </span>
                                                                                            <span id="wassce_maths_grade" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_maths_grade }}
                                                                                            </span>
                                                                                            <span id="wassce_sub1" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_three_grade }}
                                                                                            </span>
                                                                                            <span id="wassce_sub2" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_four_grade }}
                                                                                            </span>
                                                                                            <span id="wassce_sub3" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_five_grade }}
                                                                                            </span>
                                                                                            <span id="wassce_sub4" class="form-control">
                                                                                                {{ $applied_applicant->wassce_subject_six_grade }}
                                                                                            </span>
                                                                                        </b>
                                                                                    </td>
                                                                                    <td>
                                                                                        <b>
                                                                                            <span id="results_slip_one" class="form-control">
                                                                                                {{ $applied_applicant->results_slip_one }}
                                                                                            </span>
                                                                                            <span id="results_slip_two" class="form-control">
                                                                                                {{ $applied_applicant->results_slip_two }}
                                                                                            </span>
                                                                                            <span id="results_slip_three" class="form-control">
                                                                                                {{ $applied_applicant->results_slip_three }}
                                                                                            </span>
                                                                                            <span id="results_slip_four" class="form-control">
                                                                                                {{ $applied_applicant->results_slip_four }}
                                                                                            </span>
                                                                                            <span id="results_slip_five" class="form-control">
                                                                                                {{ $applied_applicant->results_slip_five }}
                                                                                            </span>
                                                                                            <span id="results_slip_six" class="form-control">
                                                                                                {{ $applied_applicant->results_slip_six }}
                                                                                            </span>
                                                                                        </b>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                            </table>
                                                        </div>
                                                          @if($applied_applicant->entrance_type === 'TOP UP')
                                                            <div class="row" style="margin-left: 0.5cm; margin-right: 0.5cm;">
                                                                 <table class="table table-bordered">
                                                                       <thead>
                                                                           <tr>
                                                                              <th>INSTITUTION</th>
                                                                              <th>NMC</th>
                                                                              <th>TRANSCRIPT</th>
                                                                           </tr>
                                                                        </thead>
                                                                <tbody>
                                                               <tr>
                                                                      <td><b>{{ $applied_applicant->institution }}</b></td>
                                                                       <td id="results_certificate">
                                                                            @if (!empty($applied_applicant->results_certificate))

                                                                            Selected file:
                                                                            <a href="{{ asset($applied_applicant->results_certificate) }}"
                                                                                target="_blank">View PDF</a>
                                                                        @endif

                                                                        </td>
                                                                       <td id="transcript">
                                                                            @if (!empty($applied_applicant->transcript))

                                                                            Selected file:
                                                                            <a href="{{ asset($applied_applicant->transcript) }}"
                                                                                target="_blank">View PDF</a>
                                                                        @endif
                                                                        </td>

                                                                 </tr>
                                                             </tbody>
                                                         </table>
                                                       </div>
                                                    @endif

                                                    </div>
                                                    <div class="col-md-12">
                                                        <div style="">
                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <h5 class="mt-12" style="color: red">
                                                                        Applicant Declaration</h5>
                                                                    <hr>
                                                                    <form method="POST"
                                                                    action="{{ route('document.status-save-documentation', $applied_applicant->uuid) }}">
                                                                    @csrf
                                                                    <input type="hidden" name="applicant_id" value="{{ $applied_applicant->id }}">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <select class="custom-select" name="result_verified" required>
                                                                                <option value="">Open this select menu</option>
                                                                                <option value="QUALIFIED">QUALIFIED</option>
                                                                                <option value="DISQUALIFIED">DISQUALIFIED</option>
                                                                                <option value="PENDING">PENDING</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-sm-6">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control" name="result_verified_remarks">Resulted Verified</textarea>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('bece_certificate').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.size > 1048576) {
                    filePreview.textContent = 'File size exceeds 1MB. Please select a smaller file.';
                    fileInput.value = ''; // Clear the file input
                    return; // Exit the function if the file is too large
                }

                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>

    <script>
        document.getElementById('wassce_certificate').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('wassce-file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.size > 1048576) {
                    filePreview.textContent = 'File size exceeds 1MB. Please select a smaller file.';
                    fileInput.value = ''; // Clear the file input
                    return; // Exit the function if the file is too large
                }

                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>


 <script>
        document.getElementById('birth_certificate').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.size > 1048576) {
                    filePreview.textContent = 'File size exceeds 1MB. Please select a smaller file.';
                    fileInput.value = ''; // Clear the file input
                    return; // Exit the function if the file is too large
                }

                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>


 <script>
        document.getElementById('results_certificate').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('results_certificate-file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.size > 1048576) {
                    filePreview.textContent = 'File size exceeds 1MB. Please select a smaller file.';
                    fileInput.value = ''; // Clear the file input
                    return; // Exit the function if the file is too large
                }

                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>

 <script>
        document.getElementById('transcript').addEventListener('change', function(event) {
            var fileInput = event.target;
            var filePreview = document.getElementById('transcript-file-preview');
            // Clear previous preview
            filePreview.innerHTML = '';
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                if (file.size > 1048576) {
                    filePreview.textContent = 'File size exceeds 1MB. Please select a smaller file.';
                    fileInput.value = ''; // Clear the file input
                    return; // Exit the function if the file is too large
                }

                if (file.type === 'application/pdf') {
                    // Display file name
                    var fileName = document.createElement('p');
                    fileName.textContent = 'Selected file: ' + file.name;
                    filePreview.appendChild(fileName);
                    // Optionally, provide a link to open the PDF
                    var fileLink = document.createElement('a');
                    fileLink.href = URL.createObjectURL(file);
                    fileLink.textContent = 'View PDF';
                    fileLink.target = '_blank';
                    filePreview.appendChild(fileLink);
                } else {
                    filePreview.textContent = 'Please select a PDF file.';
                }
            }
        });
    </script>

@endsection
