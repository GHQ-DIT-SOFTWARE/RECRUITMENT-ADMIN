@extends('admin.layout.master')
@section('title')
 WASSCE SUBJECT
@endsection
@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Wassce</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Wassce</a></li>
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
                            <p>Perform these Actions on Wassce.</p>
                        </div>
                        <div class="col-sm-6 text-right"><br />
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="{{ route('subject.mech-wassce-subject') }}" class="btn  btn-primary "
                                    type="button" aria-haspopup="true" aria-expanded="false"><i
                                        class="feather icon-plus"></i>Mech
                                </a>
                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <div class="dt-responsive table-responsive">
                                <table id="example" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th>WASSCE SUBJECT</th>
                                             <th>PROGRAM</th>
                                            <th width="20%">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wasscesubject as $key => $record)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ $record->wasscesubjects }}
                                                </td>
                                                 <td>
                                                    {{ $record->main_course }}
                                                </td>
                                                <td>
                                                     <a class="btn btn-secondary btn-sm"
                                                        href="{{ route('subject.edit-wassce-subject', $record->uuid) }}"><i
                                                            class="feather icon-edit-2"></i></a>
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('subject.delete-wassce-subject', $record->uuid) }}"
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

@endsection
