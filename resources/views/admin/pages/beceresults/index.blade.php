@extends('admin.layout.master')
@section('title')
    BECE RESULTS
@endsection
@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Region</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Region</a></li>
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
                            <p>Perform these Actions on Region.</p>
                        </div>
                        <div class="col-sm-6 text-right"><br />
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="{{ route('results.mech-bece-results') }}" class="btn  btn-primary " type="button"
                                    aria-haspopup="true" aria-expanded="false"><i class="feather icon-plus"></i>Mech
                                </a>
                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="example" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                No.
                                            </th>
                                            <th>BECE RESULTS</th>
                                            <th width="20%">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($region as $key => $record)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ $record->beceresults }}
                                                </td>
                                                <td>
                                                    {{-- <a class="btn btn-primary btn-sm"
                                                        href="{{ route('edit-region', ['uuid' => $record->uuid]) }}"><i
                                                            class="feather icon-edit"> </i></a> --}}
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('results.delete-bece-results', $record->uuid) }}"
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
    </div>
@endsection
