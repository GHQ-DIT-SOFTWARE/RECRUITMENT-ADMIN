@extends('admin.layout.master')
@section('title')
    Aptitude Test
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
                        <h5 class="m-b-10">Aptitude Test </h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        {{-- <li class="breadcrumb-item"><a href="#">report</a></li> --}}
                        <li class="breadcrumb-item"><a href="#">Aptitude Test Phase</a></li>
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
                        <h5>APTITUDE TEST SCORE</h5>
                    </nav>
                </div>
            </div>
            <!-- The table is hidden by default -->
            <div class="card" id="results-table" >
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="dt-responsive table-responsive">
                            <table id="main-aptitude" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>RESULTS VERIFICATION</th>
                                         <th>ENTRANCE TYPE</th>
                                        <th>SERIAL NUMBER</th>
                                        <th>COURSE</th>
                                        <th>SURNAME</th>
                                        <th>FIRST NAME</th>
                                        <th>OTHERNAMES</th>
                                        <th>GENDER</th>
                                        <th>MOBILE</th>
                                        <th>MARKS</th>
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
         var dataTable = $('#main-aptitude').DataTable({
          dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        buttons: ['colvis', 'copy', 'excel'],
        scrollY: 960,
        scrollCollapse: true,
        processing: true,
        serverSide: true,
        lengthMenu: [[15, 25, 50, 100, 200, -1], [15, 25, 50, 100, 200, 'All']],
        ajax: {
            url: "{{route('api-applicant-aptitude-test')}}",
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: function(d) {
                var formData = $('#filter-form').serializeArray();
                $.each(formData, function(index, item) {
                    d[item.name] = item.value;
                });
            },
        },
        columns: [
            { data: null, orderable: false, searchable: false, render: function(data, type, full, meta) { return meta.row + 1; } },
            { data: 'qualification', name: 'qualification' },
            { data:'entrance_type',
             name:'entrance_type' },
            { data: 'applicant_serial_number', name: 'applicant_serial_number' },
            { data: 'cause_offers', name: 'cause_offers' },
            { data: 'surname', name: 'surname' },
             {
                        data: 'first_name',
                        name: 'first_name'
                    },
            { data: 'other_names', name: 'other_names' },
            { data: 'sex', name: 'sex' },
            { data: 'contact', name: 'contact' },
            {
                data: 'aptitude_marks',
                name: 'aptitude_marks',
                render: function(data, type, row) {
                    return `<input type="number" class="form-control marks-input" data-id="${row.id}" value="${data}" min="0" max="100">`;
                }
            }
        ],
    });

    // Handle marks input change
    $(document).on('change', '.marks-input', function() {
        var applicantId = $(this).data('id');
        var newMarks = $(this).val();
        $.ajax({
    url: "{{ route('test.store-applicant-aptitude') }}",  // Adjust this route
    type: "POST",
    data: {
        _token: "{{ csrf_token() }}",
        applicant_id: applicantId,
        aptitude_marks: newMarks
    },
    success: function(response) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: response.message || 'Marks updated successfully!',
        confirmButtonText: 'OK'
    }).then(() => {
        // Refresh the page after user clicks OK
        location.reload();
    });
},
error: function(xhr) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Error saving marks. Please try again.',
        confirmButtonText: 'Retry'
    });
}


    // success: function(response) {
    //     if (response.message) {
    //         alert(response.message); // Show success message
    //     } else {
    //         alert("Marks updated successfully!");
    //     }
    //     // Refresh the page after alert
    //     location.reload();
    // },
    // error: function(xhr) {
    //     alert('Error saving marks. Please try again.');
    // }
});

    });

    $('#filter-form').submit(function(e) {
        e.preventDefault();
        dataTable.ajax.reload();
        $('#results-table').show();
        this.reset();
    });
});

    </script>
@endsection
