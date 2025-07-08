@extends('admin.layout.master')
@section('title')
    Results Verification
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
                        <h5 class="m-b-10">Verfication Phase</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">report</a></li>
                        <li class="breadcrumb-item"><a href="#">Result Verification Phase</a></li>
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
                        <h5>GENERAL RESULT VERIFICATION PHASE</h5>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                    </nav>
                </div>
            </div>

            {{-- <div class="card user-profile-list">
                <div class="col-md-12 border-right">
                    <div class="card-body">
                        <form id="filter-form">
                            @csrf
                            <div class="row filter-row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control" name="cause_offers">
                                            <option value>SELECT COURSE</option>
                                            @foreach ($data->unique('cause_offers') as $arm)
                                                <option value="{{ $arm->cause_offers }}">
                                                    {{ $arm->cause_offers }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating" name="applicant_serial_number"
                                            placeholder="Applicant Serial Number">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating" name="surname"
                                            placeholder="SURNAME">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating" name="other_names"
                                            placeholder="FIRST NAME">
                                    </div>
                                </div>
                            </div>

                            <div class="row filter-row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="sex">
                                            <option value>SELECT GENDER</option>
                                            @foreach ($data->unique('sex') as $gender)
                                                <option value="{{ $gender->sex }}">
                                                    {{ $gender->sex }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="qualification">
                                            <option value>QUALIFICATION STATUS</option>
                                            @foreach ($data->unique('qualification') as $status)
                                                <option value="{{ $status->qualification }}">
                                                    {{ $status->qualification }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="entrance_type">
                                            <option value>ENTRANCE TYPE</option>
                                            @foreach ($data->unique('entrance_type') as $list)
                                                <option value="{{ $list->entrance_type }}">
                                                    {{ $list->entrance_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <button type="sumit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div> --}}

            
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6 text-right"><br />
                        </div>
                        <input type="hidden" name="_token" value="TdknsMaNi6CJpMFbmut9YrGroWXIuiF4uRmYIKx3">
                        <div class="col-sm-6" id="checkbox_actions" style="display:none;">
                            <div class="btn-group mb-2 mr-2">
                                <button type="button" class="btn  btn-info btn-sm" data-toggle="modal"
                                    data-target="#addGroupContactModal" onclick="specify_type('group')">Add To
                                    Group</button>
                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table id="main-report-blade" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            No.
                                        </th>
                                         <th>STATUS</th>
                                        <th>SERIAL NUMBER</th>
                                        <th>ENTRANCE TYPE</th>
                                        <th>SURNAME</th>
                                        <th>FIRST NAME</th>
                                        <th>OTHERNAMES</th>
                                        <th>GENDER</th>
                                        <th>COURSE</th>
                                        <th>MOBILE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
    <script>
        $(document).ready(function() {
            var dataTable = $('#main-report-blade').DataTable({
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
                    url: "{{ route('generate-applicant-report') }}",
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
                        data: 'applicant_serial_number',
                        name: 'applicant_serial_number'
                    },
                    {
                        data:'entrance_type',
                        name:'entrance_type'
                    },
                    {
                        data: 'surname',
                        name: 'surname'
                    },
                     {
                        data: 'first_name',
                        name: 'first_name'
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
                        data: 'cause_offers',
                        name: 'cause_offers'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });

            $('#filter-form').submit(function(e) {
                e.preventDefault();
                dataTable.ajax.reload();
            });
        });
    </script>
@endsection
