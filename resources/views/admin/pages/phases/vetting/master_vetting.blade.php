@extends('admin.layout.master')
@section('title')
    Master Vetting
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
                        <h5 class="m-b-10">General Vetting Reporting </h5>
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
                                <!-- Commission Type -->
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control" name="commission_type">
                                            <option value>SELECT COMMISSION TYPE</option>
                                            @foreach ($data->pluck('applicant')->unique('commission_type') as $applicant)
                                                <option value="{{ $applicant->commission_type }}">
                                                    {{ $applicant->commission_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Arm of Service -->
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control" name="arm_of_service">
                                            <option value>SELECT ARM OF SERVICE</option>
                                            @foreach ($data->pluck('applicant')->unique('arm_of_service') as $applicant)
                                                <option value="{{ $applicant->arm_of_service }}">
                                                    {{ $applicant->arm_of_service }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Surname -->
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating" name="surname"
                                            placeholder="SURNAME">
                                    </div>
                                </div>

                                <!-- Serial Number -->
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating" name="applicant_serial_number"
                                            placeholder="Serial Number">
                                    </div>
                                </div>
                            </div>

                            <div class="row filter-row">
                                <!-- Gender -->
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="sex">
                                            <option value>SELECT GENDER</option>
                                            @foreach ($data->pluck('applicant')->unique('sex') as $applicant)
                                                <option value="{{ $applicant->sex }}">
                                                    {{ $applicant->sex }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Branch -->
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="branch">
                                            <option value>SELECT BRANCH</option>
                                            @foreach ($data->pluck('applicant.branches')->unique('branch') as $branch)
                                                @if ($branch)
                                                    <option value="{{ $branch->id }}">
                                                        {{ $branch->branch }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Region -->
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="region">
                                            <option value>SELECT REGION</option>
                                            @foreach ($data->pluck('applicant.regions')->unique('region_name') as $region)
                                                @if ($region)
                                                    <option value="{{ $region->id }}">
                                                        {{ $region->region_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Qualification -->
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="qualification">
                                            <option value>SELECT QUALIFICATION STATUS</option>
                                            @foreach ($data->unique('vetting_status') as $status)
                                                <option value="{{ $status->vetting_status }}">
                                                    {{ $status->vetting_status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Filter Button -->
                                <div class="col-sm-6 col-md-3">
                                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            </div> --}}
                        </form>

                    </div>
                </div>
            </div>

            <!-- Show the table by default -->
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="dt-responsive table-responsive">
                            <table id="main-vettings" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>SURNAME</th>
                                        <th>OTHERNAMES</th>
                                        <th>GENDER</th>
                                        <th>COMMISSION TYPE</th>
                                        <th>ARM OF SERVICE</th>
                                        <th>MOBILE</th>
                                        <th>REGION</th>
                                        <th>BRANCH</th>
                                        <th>SERIAL NUMBER</th>
                                        <th>VETTING STATUS</th>
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
            var dataTable = $('#main-vettings').DataTable({
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
                    url: "{{ route('api-master-vettings') }}",
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
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('An error occurred while loading data. Please try again.');
                    }
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
                        data: 'vetting_status',
                        name: 'vetting_status'
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
                this.reset();
            });
        });
    </script>
@endsection
