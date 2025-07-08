@extends('admin.layout.master')
@section('title')
Faculty
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Faculty</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Faculty</a></li>
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
                            <p>Perform Actions</p>
                        </div>
                        <div class="col-sm-6 text-right"><br />
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                               <!-- This triggers the modal instead of linking to another page -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFacultyModal">
    <i class="feather icon-plus"></i> Add Faculty
</button>

                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="example" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="select_all"
                                                        value="1" id="contactstable-select-all">
                                                    <label class="custom-control-label" for="contactstable-select-all">
                                                    </label>
                                                </div>
                                            </th>
                                            <th>Faculties</th>
                                            <th width="20%">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($faculty as $key => $record)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $record->faculty_name }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('edit-faculty', $record->uuid) }}"><i
                                                            class="feather icon-edit"> </i></a>
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('destroy-faculty', $record->uuid) }}"
                                                        title="Delete Data" id="delete"><i
                                                            class="feather icon-trash-2"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="addFacultyModal" tabindex="-1" role="dialog" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('store-faculty') }}" method="POST" id="myForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFacultyModalLabel">Enter Faculty</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="faculty_name">Faculty</label>
                        <input type="text" class="form-control" name="faculty_name" placeholder="Faculty">
                        @error('faculty_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

@endsection
