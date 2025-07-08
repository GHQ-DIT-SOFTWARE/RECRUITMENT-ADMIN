@extends('admin.layout.master')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Course</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Course</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dasboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card user-profile-list">
                <div class="card-header">
                    <h5>Details</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6 text-left"><br />
                            <p>Perform these Actions on Branch.</p>
                        </div>
                        <div class="col-sm-6 text-right"><br />
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="{{ route('course.mech-courses') }}" class="btn  btn-primary " type="button"
                                    aria-haspopup="true" aria-expanded="false"><i class="feather icon-plus"></i>Mech
                                    Course</a>
                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table id="courses" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th width="5%">No.</th>
                                        <th>Branch</th>
                                        <th>Courses</th>
                                        <th>Status</th>
                                        <th width="20%">ACTION</th>
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
            var table = $('#courses').DataTable({
                scrollY: 960,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('course.view-courses') }}",
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
                        data: null,
                        name: 'service_branches.branch',
                        render: function(data, type, full, meta) {
                            return full.service_branches ? full.service_branches.branch : '';
                        }
                    },
                    {
                        data: 'course_name',
                        name: 'course_name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, full, meta) {
                            var statusClass = data ? 'badge-success' : 'badge-warning';
                            var statusText = data ? 'Available' : 'Unavailable';
                            return '<a href="#" class="toggle-status badge ' + statusClass +
                                '" data-uuid="' + full.uuid + '">' + statusText + '</a>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#courses').on('click', '.toggle-status', function(e) {
                e.preventDefault();
                var $this = $(this);
                var uuid = $this.data('uuid');
                $.ajax({
                    url: '{{ route('course.toggle-status', '') }}/' + uuid,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            table.ajax.reload();
                            var newStatusClass = response.new_status ? 'badge-success' :
                                'badge-warning';
                            var newStatusText = response.new_status ? 'Available' :
                                'Unavailable';
                            $this.removeClass('badge-success badge-warning').addClass(
                                newStatusClass).text(newStatusText);
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while toggling the status.');
                    }
                });
            });
        });
    </script>
@endsection
