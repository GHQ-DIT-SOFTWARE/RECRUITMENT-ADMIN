@extends('admin.layout.master')
@section('title')
SUBJECT ALLOCATION
@endsection
@section('content')

<style>
    h3, h5, h6 {
        font-weight: bold;
        color: #023c13;
    }

    h6 {
        font-style: italic;
        color: #adb5bd;
    }

    .list-group-item {
        border: 1px solid #e0e0e0;
        background: #fdfdfd;
        padding: 10px 20px;
        border-radius: 6px;
        margin-bottom: 5px;
    }

    .card.user-profile-list {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    #toggle-form {
        float: right;
        margin-top: -5px;
    }

    .form-container-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
    }

    .form-control {
        min-width: 180px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .form-textarea {
        flex: 2;
        resize: none;
        height: 40px;
    }

    .form-button {
        background-color: #adb5bd;
        color: #fff;
        padding: 10px 20px;
        border: none;
        font-weight: bold;
        border-radius: 6px;
        transition: 0.3s;
    }

    .form-check {
        margin-bottom: 5px;
    }


    .form-button:hover {
        background-color: #adb5bd;
    }

    .page-header-title h5 {
        color: #023c13;
        font-weight: 600;
    }

    .breadcrumb-item a {
        color: #007bff;
    }

    .container h3 {
        margin-bottom: 20px;
    }
</style>

 <!-- Breadcrumb -->
 <div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10" style="color:white;">Subject Allocation</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Subject Allocation</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Add Package Form -->
<div class="row justify-content-center">
    <div class="col-sm-12">
        <div class="card user-profile-list">
            <div class="card-body">
                <b>Allocate New Subject
                    <button id="toggle-form" class="btn btn-success btn-sm" style="background-color: #adb5bd;border-radius: 6px;">Add</button>
                </b>
                <form id="allocation-form" action="#" style="display: none; margin-top: 15px;" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-container-row">
                        <div style="flex: 1 1 20%;">
                            <select class="form-control" name="course_id" required>
                                <option value="">--Select Course/Program--</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->cause_offers }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="flex: 1 1 20%;">
                            <select class="form-control" name="level" required>
                                <option value="">--Select Level--</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                            </select>
                        </div>

                        <div style="flex: 1 1 20%;">
                            <select class="form-control" name="semester" required>
                                <option value="">--Select Semester--</option>
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                            </select>
                        </div>

                        <div class="form-control" style="flex: 1 1 20%; padding: 10px; max-height: 200px; overflow-y: auto;">
                            <label><strong>Select Course Subjects:</strong></label><br>
                            @foreach($category as $cat)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category_id[]" value="{{ $cat->id }}" id="cat-{{ $cat->id }}">
                                    <label class="form-check-label" for="cat-{{ $cat->id }}">
                                        {{ $cat->category_name }} - Level {{ $cat->level }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div style="flex: 1 1 20%;">
                            <select class="form-control" name="lecturer_id" required>
                                <option value="">--Select Lecturer--</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="flex: 1 1 45%;">
                            <textarea class="form-control form-textarea" name="remarks" placeholder="Enter Remarks"></textarea>
                        </div>

                        <div style="flex: 1 1 100%; text-align: right;">
                            <button class="form-button" type="submit">Allocate</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Package Display -->
<div class="row justify-content-center">
    <div class="col-sm-12">
        <div class="card user-profile-list">
            <div class="card-body">
                <div class="container mt-3">
                    <div id="package-list"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function () {
        $("#toggle-form").click(function () {
            $("#allocation-form").slideToggle();
            $(this).text($("#allocation-form").is(":visible") ? "Close" : "Add");
        });

        fetchPackages();

        $("#allocation-form").submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            $.ajax({
                url: "{{ route('admin.user.course.add') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    alert("Subjects(s) assigned  successfully");
                    $("#allocation-form")[0].reset();
                    fetchPackages();
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        function fetchPackages() {
        $.get("{{ route('api.user.courses') }}", function (data) {
        let output = "";

        $.each(data, function (_, lecturerData) {
            output += `<h6 class="mt-3">Lecturer: ${lecturerData.lecturer.name}</h6>`;

            $.each(lecturerData.levels, function (level, semesters) {
                output += `<h5 class="mt-2">Level: ${level}</h5>`;

                $.each(semesters, function (semester, subjects) {
                    output += `<h6 class="mt-1">${semester}</h6><ul class="list-group mb-3">`;

                    $.each(subjects, function (_, subject) {
                        output += `<li class="list-group-item">
                            ${subject.id}
                            <small class="text-muted">
                                ${Array.isArray(subject.category_names) ? subject.category_names.join(', ') : subject.category_names} (${subject.remarks})
                            </small>

                            <button class="btn btn-white delete-btn" style="float:right;" data-id="${subject.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </li>`;

                    });

                    output += `</ul>`;
                });
            });
        });

        $("#package-list").html(output);
        });
        }


        $(document).on("click", ".delete-btn", function () {
            const allocationId = $(this).data("id");
            if (confirm("Are you sure you want to delete this subject?")) {
                $.ajax({
                    url: `{{ url('admin/course-packaging/delete') }}/${allocationId}`,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },
                    success: function () {
                        alert("Package deleted successfully");
                        fetchPackages();
                    },
                    error: function (xhr) {
                        alert("Error deleting package: " + xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endsection
