@extends('admin.layout.master')
@section('title')
    Student Results
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Student Results</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">report</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav class="navbar justify-content-between p-0 align-items-center">
                        <h5>STUDENT RESULTS</h5>
                    </nav>
                </div>
            </div>

            <div class="card user-profile-list">
                <div class="col-md-12 border-right">
                    <div class="card-body">
                        <form id="filter-form" method="GET" action="{{ route('lecturer.students.results') }}">
                            @csrf
                            <div class="row filter-row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group form-focus">
                                        <label for="search_query" style="font-size: 14px; color: #f80404;">
                                            You can search Level (eg.100,200..etc.)
                                        </label>
                                        <input type="text"
                                           class="form-control floating"
                                           name="search_query"
                                           placeholder="Search..."
                                           maxlength="3"
                                           pattern="\d{3}"
                                           inputmode="numeric"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);"
                                           style="border-radius: 50px; padding: 10px 20px; border: 1px solid #ccc; box-shadow: none; outline: none;">

                                    </div>
                                </div>
                            </div>

                            <div class="row filter-row">
                                <div class="col-sm-6 col-md-3">
                                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- The table is hidden by default -->
            @if($students->count() > 0)
                @foreach($students as $level => $groupedBySemester)
                    <div class="card mt-4">
                        <div class="card-header">
                            <strong>LEVEL {{ $level }}</strong>
                        </div>
                        <div class="card-body">
                            @foreach($groupedBySemester as $semester => $records)
                                <h6>Semester: {{ $semester }}</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>NAME</th>
                                                <th>GENDER</th>
                                                <th>INDEX NUMBER</th>
                                                <th>COURSE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($records as $index => $student)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $student->student_name }}</td>
                                                    <td>{{ $student->sex }}</td>
                                                    <td>{{ $student->index_number }}</td>
                                                    <td>{{ $student->subject_name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info mt-4">No student records found for the selected level.</div>
            @endif

        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            var dataTable = $('#main-aptitude').DataTable({
                dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons: [
                    'colvis',
                    {
                        extend: 'copy',
                        text: 'Copy to clipboard'
                    },
                    'excel',
                ],
                scrollY: 960,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('api-applicant-aptitude-test') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        var formData = $('#filter-form').serializeArray();
                        $.each(formData, function(index, item) {
                            d[item.name] = item.value;
                        });
                    },
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'qualification',
                        name: 'qualification'
                    },
                    {
                        data: 'surname',
                        name: 'surname'
                    },
                    {
                        data: 'other_names',
                        name: 'other_names'
                    },
                    {
                        data: 'sex',
                        name: 'sex'
                    },
                    {
                        data: 'commission_type',
                        name: 'commission_type'
                    },
                    {
                        data: 'arm_of_service',
                        name: 'arm_of_service'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
                    },
                    {
                        data: 'region_name',
                        name: 'region_name'
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'applicant_serial_number',
                        name: 'applicant_serial_number'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
            // Handle the form submission
            $('#filter-form').submit(function(e) {
                e.preventDefault();
                dataTable.ajax.reload();
                // Show the table after form submission
                $('#results-table').show();
                // Clear the form fields after submission
                this.reset();
            });
        });
    </script> --}}
@endsection
