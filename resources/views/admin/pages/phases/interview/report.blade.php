@extends('admin.layout.master')
@section('title')
    INTERVIEW
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
                        <h5 class="m-b-10">Interview</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Interview Phase</a></li>
                        {{-- <li class="breadcrumb-item"><a href="#">Dashboard</a></li> --}}
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
                        <h5>INTERVIEW PHASE</h5>
                    </nav>
                </div>
            </div>


            <!-- The table is hidden by default -->
            <div class="card" id="results-table">
                <div class="card-header">
                    <nav class="navbar justify-content-between p-0 align-items-center">
                        <h5>Check Pass Applicants</h5>
                        <div class="col-sm-6 text-right"><br />

                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="#" class="btn btn-danger btn-rounded waves-effect waves-light"
                                    style="float:right;" id="bulkDisqualifyBtn">
                                    <i class="fas fa-times"></i> Disqualify
                                </a>
                            </div>

                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="#" class="btn btn-success btn-rounded waves-effect waves-light"
                                    style="float:right;" id="bulkApproveBtn">
                                    <i class="fas fa-check-double"></i>Qualify
                                </a>
                            </div>
                            <div class="text-right" style="float: right;">
                                <div class="form-check form-switch"
                                    style="display: inline-flex; padding: 0.75em 2em; color: #fff; background-color:rgb(151, 195, 75)">
                                    <input class="form-check-input" type="checkbox" id="checkAllToggle">
                                    <label class="form-check-label" for="checkAllToggle">Check</label>
                                </div>
                            </div>
                        </div>

                    </nav>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="dt-responsive table-responsive">
                            <table id="main-interview" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>CHECK</th>
                                        <th>STATUS</th>
                                        <th>ENTRANCE TYPE</th>
                                        <th>SERIAL NUMBER</th>
                                        <th>SURNAME</th>
                                         <th>FIRST NAME</th>
                                        <th>OTHERNAMES</th>
                                        <th>GENDER</th>
                                        <th>MOBILE</th>
                                        <th>COURSE</th>


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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to toggle all checkboxes
            function toggleAll() {
                var checkboxes = document.querySelectorAll('.approve-checkbox');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = !checkbox.checked;
                });
            }
            // Event listener for the Check All toggle
            document.getElementById('checkAllToggle').addEventListener('change', function() {
                toggleAll();
            });

            // Event listener for Bulk Approve button
            document.getElementById('bulkApproveBtn').addEventListener('click', function() {
                var checkedCheckboxes = document.querySelectorAll('.approve-checkbox:checked');
                var recordIds = Array.from(checkedCheckboxes).map(function(checkbox) {
                    return checkbox.dataset.recordId;
                });

                // ✅ Show SweetAlert2 if no checkboxes are selected
                if (recordIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Applicants Selected',
                        text: 'Please select at least one applicant before proceeding.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Get CSRF token from the page
                var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

                // Confirmation before submitting
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to approve the selected applicants.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Approve',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make AJAX request to the server
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('test.pass-applicants-for-admission') }}',
                            data: {
                                record_ids: recordIds,
                            },
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Status successfully updated!',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong! Please try again.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
<script>
 document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('bulkDisqualifyBtn').addEventListener('click', function() {
        var checkedCheckboxes = document.querySelectorAll('.approve-checkbox:checked');
        var recordIds = Array.from(checkedCheckboxes).map(function(checkbox) {
            return checkbox.dataset.recordId;
        });

        if (recordIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Applicants Selected',
                text: 'Please select at least one applicant before proceeding.',
                confirmButtonText: 'OK'
            });
            return;
        }
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to disqualify the selected applicants.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Disqualify',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('test.disqualify-applicants') }}',
                    data: {
                        record_ids: recordIds,  // Ensure correct name
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.responseJSON.message || 'Something went wrong!',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});

</script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#main-interview').DataTable({
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
                    url: "{{ route('api-applicant-interview') }}",
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
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'qualification',
                        name: 'qualification'
                    },
                    { data:'entrance_type',
                     name:'entrance_type' },
                     {
                        data: 'applicant_serial_number',
                        name: 'applicant_serial_number'
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
                        data: 'contact',
                        name: 'contact'
                    },
                    { data: 'cause_offers', name: 'cause_offers' },
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
