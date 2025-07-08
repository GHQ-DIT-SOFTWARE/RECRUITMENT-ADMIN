@extends('admin.layout.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Branch Details</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Branch</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Enter Sub Branch.</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('store-sub-sub-branch') }}" method="POST" id="myForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="branch" class="col-sm-3 col-form-label">Main Branch</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="branch_id" name="branch_id"
                                            placeholder="">
                                             <option value="">Select Branch</option>
                                            @foreach ($branch as $list)
                                                <option value="{{ $list->id }}">{{ $list->branch }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="branch" class="col-sm-3 col-form-label">Sub Branch</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="sub_branch_id" name="sub_branch_id"
                                            placeholder="">

                                        </select>
                                        @error('sub_branch_id')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="sub_sub_branch" class="col-sm-3 col-form-label">Sub Sub Branch</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="sub_sub_branch" placeholder="Branch">
                                        @error('sub_sub_branch')
                                            <span class="btn btn-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                            </div>


                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn  btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $('#branch_id').on('change', function () {
            var branchId = $(this).val();
            if (branchId) {
                $.ajax({
                    url: '/admin/sub-sub-branches/get-sub-branches/' + branchId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#sub_branch_id').empty();
                        $('#sub_branch_id').append('<option value="">Select Sub Branch</option>');
                        $.each(data, function (key, value) {
                            $('#sub_branch_id').append('<option value="' + value.id + '">' + value.sub_branch + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_branch_id').empty();
                $('#sub_branch_id').append('<option value="">Select Sub Branch</option>');
            }
        });
    });
</script>

@endsection
