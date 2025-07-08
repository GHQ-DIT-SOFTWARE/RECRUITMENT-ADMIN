@extends('admin.layout.master')
@section('title')
Departments
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
                        <h5 class="m-b-10">Department</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Department</a></li>
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
                            <p>Perform these Actions on Department.</p>
                        </div>

                        <div class="col-sm-6 text-right"><br />
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addBranchModal">
                                    <i class="feather icon-plus"></i> Add Department
                                </button>

                            </div>
                        </div>

                        <div class="dt-responsive table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="departments" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                No.
                                            </th>
                                            <th>FACULTY</th>
                                            <th>DEPARTMENT</th>
                                            <th width="20%">ACTION</th>
                                        </tr>
                                    </thead>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal -->
   <div class="modal fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form action="{{ route('store-faculty-department') }}" method="POST" id="myForm">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="addBranchModalLabel">Add Department</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="form-group row">
              <label for="faculty_id" class="col-sm-3 col-form-label">Faculty</label>
              <div class="col-sm-9">
                <select class="form-control" id="faculty_id" name="faculty_id">
                  <option value="">SELECT FACULTY</option>
                  @foreach ($faculty as $list)
                    <option value="{{ $list->id }}">{{ $list->faculty_name }}</option>
                  @endforeach
                </select>
                @error('faculty_id')
                  <span class="btn btn-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="branch" class="col-sm-3 col-form-label">Department</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="department" placeholder="Department">
                @error('department')
                  <span class="btn btn-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
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
            $('#departments').DataTable({
                scrollY: 960,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('faculty-departments') }}",
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
                        data: 'faculty',
                        name: 'faculty'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
