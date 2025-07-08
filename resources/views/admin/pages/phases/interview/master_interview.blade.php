@extends('admin.layout.master')
@section('title')
Admission-Letters
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
                        <h5 class="m-b-10">Notifying Applicants With Admission Letters </h5>
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
                        <h5>Notify Applicants</h5>
                        <div id="processingMessage" class="text-primary fw-bold d-none">
    Processing Admission Letters To Applicants...
</div>

                    </nav>
                </div>
            </div>

            <div class="card user-profile-list">
               <div class="card">
                <div class="card-header border-0">
                    <div class="col-md-12 border-right">
                        <div class="card-body">
                            <button type="button" class="btn text-white" style="background-color: #adb5bd;" data-bs-toggle="modal" data-bs-target="#notifyModal">
                                Notify All Qualified Applicants
                            </button>

                        </div>
                    </div>
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
                                         <th>FIRST NAME</th>
                                        <th>OTHERNAMES</th>
                                        <th>GENDER</th>
                                        <th>MOBILE</th>
                                        <th>SERIAL NUMBER</th>
                                        <th>STATUS</th>
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


<div class="modal fade" id="notifyModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="notifyForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="notifyModalLabel">Notify Qualified Applicants</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="confirmNotify" name="confirm">
            <label class="form-check-label" for="confirmNotify">
              Are you sure you want to notify all qualified applicants?
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Send Notifications</button>
        </div>
      </form>
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
                    url: "{{ route('api-master-interview') }}",
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
                    {
                        data: 'applicant_serial_number',
                        name: 'applicant_serial_number'
                    },
                    {
                        data: 'interview_status',
                        name: 'interview_status'
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

<script>
$(document).ready(function () {
    $('#notifyForm').submit(function (e) {
        e.preventDefault();

        if (!$('#confirmNotify').is(':checked')) {
            Swal.fire({
                icon: 'warning',
                title: 'Confirmation Required',
                text: 'Please confirm that you want to notify all qualified applicants.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        // Show processing message
        $('#processingMessage').removeClass('d-none');

        // Disable the submit button
        $('#notifyForm button[type="submit"]').prop('disabled', true).text('Processing...');

        $.ajax({
            url: "{{ route('test.send-notify-bulk-qualified-admission') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                confirm: true
            },
            success: function (response) {
                // Hide modal and processing message
                $('#notifyModal').modal('hide');
                $('#processingMessage').addClass('d-none');

                // Reset button
                $('#notifyForm button[type="submit"]').prop('disabled', false).text('Send Notifications');

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message || 'Notifications sent successfully.',
                    confirmButtonColor: '#3085d6'
                });
            },
            error: function () {
                $('#processingMessage').addClass('d-none');
                $('#notifyForm button[type="submit"]').prop('disabled', false).text('Send Notifications');

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to send notifications.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});
</script>



{{-- <script>
$(document).ready(function () {
    $('#notifyForm').submit(function (e) {
        e.preventDefault();

        if (!$('#confirmNotify').is(':checked')) {
            Swal.fire({
                icon: 'warning',
                title: 'Confirmation Required',
                text: 'Please confirm that you want to notify all qualified applicants.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        $.ajax({
            url: "{{ route('test.send-notify-bulk-qualified-admission') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                confirm: true
            },
            success: function (response) {
                $('#notifyModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message || 'Notifications sent successfully.',
                    confirmButtonColor: '#3085d6'
                });
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to send notifications.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});
</script> --}}


@endsection
