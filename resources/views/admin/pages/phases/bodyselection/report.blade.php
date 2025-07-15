@extends('admin.layout.master')
@section('title')
    Body Selection
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
                        <h5 class="m-b-10">General Report</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">report</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
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
                        <h5>GENERAL REPORT GENERATION</h5>
                    </nav>
                </div>
            </div>

            <div class="card user-profile-list">
                <div class="col-md-12 border-right">
                    <div class="card-body">
                        <form id="filter-form">
                            @csrf
                            <div class="row filter-row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group form-focus">
                                        <label for="search_query" style="font-size: 14px; color: #f80404;">
                                            You can search by GAF NUMBER, name, branch, commission type, etc.
                                        </label>
                                        <input type="text" class="form-control floating" name="search_query"
                                            placeholder="Search..."
                                            style="border-radius: 50px; padding: 10px 20px; border: 1px solid #ccc; box-shadow: none; outline: none;">
                                    </div>
                                </div>
                            </div>

                            <div class="row filter-row">
                                <div class="col-sm-6 col-md-3">
                                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>
                            </div>
                            {{-- <div class="row filter-row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control" name="commission_type">
                                            <option value>SELECT COMMISSION TYPE</option>
                                            @foreach ($data->unique('commission_type') as $commission)
                                                <option value="{{ $commission->commission_type }}">
                                                    {{ $commission->commission_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control" name="rank_name">
                                            <option value>SELECT ARM OF SERVICE</option>
                                            @foreach ($data->unique('arm_of_service') as $arm)
                                                <option value="{{ $arm->arm_of_service }}">
                                                    {{ $arm->arm_of_service }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                        <input type="text" class="form-control floating" name="applicant_serial_number"
                                            placeholder="Serial Number">
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
                                        <select class="form-control select2" name="branch">
                                            <option value>SELECT BRANCH</option>
                                            @foreach ($data->unique('branch') as $applicant)
                                                @if ($applicant->branches)
                                                    <option value="{{ $applicant->branches->id }}">
                                                        {{ $applicant->branches->branch }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="region">
                                            <option value>SELECT REGIONS</option>
                                            @foreach ($data->unique('region') as $applicant)
                                                @if ($applicant->regions)
                                                    <option value="{{ $applicant->regions->id }}">
                                                        {{ $applicant->regions->region_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="qualification">
                                            <option value>SELECT QUALIFICATION STATUS</option>
                                            @foreach ($data->unique('qualification') as $status)
                                                <option value="{{ $status->qualification }}">
                                                    {{ $status->qualification }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <button type="sumit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>

            <!-- The table is hidden by default -->
            <div class="card" id="results-table" style="display: none;">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="dt-responsive table-responsive">
                            <table id="main-bodyselection" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>STATUS</th>
                                        <th>SURNAME</th>
                                        <th>OTHERNAMES</th>
                                        <th>GENDER</th>
                                        <th>COMMISSION TYPE</th>
                                        <th>ARM OF SERVICE</th>
                                        <th>MOBILE</th>
                                        <th>REGION</th>
                                        <th>BRANCH</th>
                                        <th>SERIAL NUMBER</th>
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
            var dataTable = $('#main-bodyselection').DataTable({
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
                    url: "{{ route('api-applicant-body-selection') }}",
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
    </script>
@endsection
