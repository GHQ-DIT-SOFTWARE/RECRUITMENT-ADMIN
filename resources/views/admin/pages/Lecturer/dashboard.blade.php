@extends('admin.layout.master')
@section('title')
LECTURER
@endsection
@section('content')
<div class="user-profile user-card mb-4">
    <div class="card-header border-0 p-0 pb-0">
        <div class="cover-img-block">
            <div class="overlay"></div>
            <div class="change-cover">
                <div class="dropdown">
                    <a class="drp-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon feather icon-camera"></i></a>

                </div>
            </div>
        </div>
    </div>

    <div class="card-body py-0">
        <div class="user-about-block m-0">
            <div class="row">
                <div class="col-md-4 text-center mt-n5">
                    <div class="change-profile text-center">
                        <div class="dropdown w-auto d-inline-block">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="profile-dp">
                                    <div class="position-relative d-inline-block">
                                        <img class="img-radius img-fluid wid-100" src="{{ asset('assets/images/user/user1.png') }}" alt="User image">
                                    </div>
                                    <div class="overlay">
                                        <span>change</span>
                                    </div>
                                </div>
                                <div class="certificated-badge">
                                    <i class="fas fa-certificate text-c-blue bg-icon"></i>
                                    <i class="fas fa-check front-icon text-white"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="mb-2 text-muted">{{ $user->appointment }}</p>
                </div>
                <div class="col-md-8 mt-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#!" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i class="feather icon-globe mr-2 f-18"></i>www.gafconm.com</a>
                            <div class="clearfix"></div>
                            <a href="#" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i class="feather icon-mail mr-2 f-18"></i>{{ $user->email }}</a>
                            <div class="clearfix"></div>
                            <a href="#!" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i class="feather icon-phone mr-2 f-18"></i>{{ $user->phone_number }}</a>
                        </div>

                        <div class="col-md-6">
                            <div class="media">
                                <i class="feather icon-map-pin mr-2 mt-1 f-18"></i>
                                <div class="media-body">
                                    <p class="mb-0 text-muted">Nursing & Midwifery Training</p>
                                    <p class="mb-0 text-muted">37 Military Hospital, Neghelli,</p>
                                    <p class="mb-0 text-muted">Barracks</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- profile header end -->

<div class="row">
    <!-- prject ,team member start -->
    <div class="col-xl-6 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <h5>My Assigned Levels & Students</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Course(s)</th>
                                <th>Level</th>
                                <th>Total Students</th>
                                <th class="text-right">Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignedCourses as $assigned)
                                <tr class="table-primary">
                                    <td>{{ $assigned->course_name }}</td>
                                    <td>{{ $assigned->level }} Level</td>
                                    <td>{{ $assigned->total_students }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('lecturer.downloadStudents', ['courseId' => $assigned->course_id, 'level' => $assigned->level]) }}"
                                           class="btn btn-sm btn-success">
                                            <i class="feather icon-download"></i> Excel
                                        </a>
                                    </td>
                                </tr>

                                {{-- Optional: Show students --}}
                                {{-- @foreach ($assigned->students as $student)
                                    <tr>
                                        <td colspan="4">
                                            <div class="ml-4">
                                                <strong>{{ $student->surname }} {{ $student->first_name }} {{ $student->other_names }}</strong><br>
                                                Index No: {{ $student->index_number }} |
                                                Contact: {{ $student->contact }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            @endforeach
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-6 col-md-12">
        <div class="card latest-update-card">
            <div class="card-header">
                <h5>Lecturer Timeline</h5>
                <div class="card-header-right">
                    <div class="btn-group card-option">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="feather icon-more-horizontal"></i>
                        </button>
                        <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                            <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                            <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                            <li class="dropdown-item close-card"><a href="#!"><i class="feather icon-trash"></i> remove</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="latest-update-box">
                    <!-- Event 1 -->
                    <div class="row p-t-30 p-b-30">
                        <div class="col-auto text-right update-meta">
                            <p class="text-muted m-b-0 d-inline-flex">1 hr ago</p>
                            <i class="feather icon-calendar bg-c-blue update-icon"></i>
                        </div>
                        <div class="col">
                            <h6>Lecture on Data Structures</h6>
                            <p class="text-muted m-b-0">Held for 3rd-year Computer Science students.</p>
                        </div>
                    </div>
                    <!-- Event 2 -->
                    <div class="row p-b-30">
                        <div class="col-auto text-right update-meta">
                            <p class="text-muted m-b-0 d-inline-flex">5 hrs ago</p>
                            <i class="feather icon-book-open bg-c-green update-icon"></i>
                        </div>
                        <div class="col">
                            <h6>Research Paper Submitted</h6>
                            <p class="text-muted m-b-0">Topic: AI in Education.</p>
                        </div>
                    </div>
                    <!-- Event 3 -->
                    <div class="row p-b-30">
                        <div class="col-auto text-right update-meta">
                            <p class="text-muted m-b-0 d-inline-flex">Yesterday</p>
                            <i class="feather icon-users bg-c-yellow update-icon"></i>
                        </div>
                        <div class="col">
                            <h6>Faculty Meeting</h6>
                            <p class="text-muted m-b-0">Discussion on curriculum review for next semester.</p>
                        </div>
                    </div>
                    <!-- Event 4 -->
                    <div class="row p-b-0">
                        <div class="col-auto text-right update-meta">
                            <p class="text-muted m-b-0 d-inline-flex">3 days ago</p>
                            <i class="feather icon-award bg-c-red update-icon"></i>
                        </div>
                        <div class="col">
                            <h6>Journal Publication</h6>
                            <p class="text-muted m-b-10">Published in International Journal of Computing.</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="#!" class="b-b-primary text-primary">View Full Timeline</a>
                </div>
            </div>
        </div>
    </div>

    <!-- prject ,team member start -->

</div>
@endsection
