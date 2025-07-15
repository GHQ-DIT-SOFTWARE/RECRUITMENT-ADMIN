@php
    $usr = Auth::guard('web')->user();
@endphp
<nav class="pcoded-navbar menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">
            <div class="">
                <div class="collapse" id="nav-user-link">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="user-profile.html" data-toggle="tooltip"
                                title="View Profile"><i class="feather icon-user"></i></a></li>
                        <li class="list-inline-item"><a href="email_inbox.html"><i class="feather icon-mail"
                                    data-toggle="tooltip" title="Messages"></i><small
                                    class="badge badge-pill badge-primary">5</small></a></li>
                        <li class="list-inline-item"><a href="auth-signin.html" data-toggle="tooltip" title="Logout"
                                class="text-danger"><i class="feather icon-power"></i></a></li>
                    </ul>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar ">
                    <li class="nav-item active"><a href="{{ route('dashboard.analysis-dashboard') }}"
                            class="nav-link has-ripple"><span class="pcoded-micon"><i
                                    class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                @role('Admission')
                <li class="nav-item pcoded-menu-caption">
                    <label class="fs-8">Recruitment Panel</label>
                </li>
                  <li class="nav-item pcoded-hasmenu {{ Route::is('report.report-generation', 'document.master-filter-documentation', 'view-index',
                            'subject.wassce-subject-index',
                            'results.wassce-results-index',
                            'course.courses-index') ? 'active' : '' }}">
                      <a href="#!" class="nav-link">
                      <span class="pcoded-micon"><i class="feather icon-user-plus"></i></span>
                      <span class="pcoded-mtext">Recruitment Process</span>
                    </a>

                                    <ul class="pcoded-submenu">

                                        {{-- <li class="{{ Route::is('report.report-generation') ? 'active' : '' }}">
                                            <a href="{{ route('report.report-generation') }}">Verify Results</a>
                                        </li> --}}

                                          <li class="{{ Route::is('report.report-generation') ? 'active' : '' }}">
                                            <a href="{{ route('report.report-generation') }}">Initial Documentation</a>
                                        </li>
                                        <li class="{{ Route::is('bodyselection.applicant-body-selection') ? 'active' : '' }}">
                                            <a href="{{ route('bodyselection.applicant-body-selection') }}">Body Selection</a>
                                        </li>
                                          <li class="{{ Route::is('report.report-generation') ? 'active' : '' }}">
                                            <a href="{{ route('report.report-generation') }}">Trade Test</a>
                                        </li>


                                    <li class="{{ Route::is('test.applicant-aptitude-test') ? 'active' : '' }}">
                                        <a href="{{ route('test.applicant-aptitude-test') }}">Documentation</a>
                                    </li>

                                      <li class="{{ Route::is('test.applicant-medical') ? 'active' : '' }}">
                                            <a href="{{ route('test.applicant-medical') }}">Medicals</a>
                                        </li>
                                    <li class="{{ Route::is('test.applicant-vetting') ? 'active' : '' }}">
                                            <a href="{{ route('test.applicant-vetting') }}">Filter</a>
                                        </li>

                                    <li class="{{ Route::is('report.report-generation') ? 'active' : '' }}">
                                            <a href="{{ route('report.report-generation') }}">Receipt of Applicant Letter</a>




                </ul>
        </li>

          <li class="nav-item pcoded-menu-caption">
                    <label class="fs-8">Notify Applicant Panel</label>
                </li>
        <li class="nav-item pcoded-hasmenu {{ Route::is('document.master-filter-documentation', 'test.master-filter-aptitude', 'test.master-filter-interview') ? 'active' : '' }}">
           <a href="#">
    <i class="feather icon-book"></i>
    <span class="pcoded-mtext">Notify</span>
</a>
       <ul class="pcoded-submenu">
                    <li class="{{ Route::is('document.master-filter-documentation') ? 'active' : '' }}">
                        <a href="{{ route('document.master-filter-documentation') }}">Results</a>
                    </li>

                <li class="{{ Route::is('test.master-filter-aptitude') ? 'active' : '' }}">
                    <a href="{{ route('test.master-filter-aptitude') }}">Aptitude</a>
                </li>

        <li class="{{ Route::is('test.master-filter-interview') ? 'active' : '' }}"><a
            href="{{ route('test.master-filter-interview') }}">Interview</a>
        </li>
        </ul>
        </li>
        @endrole


            <li class="nav-item pcoded-menu-caption">
                    <label class="fs-8">System Settings</label>
                </li>
        <li class="nav-item pcoded-hasmenu">
           <a href="#">
    <i class="feather icon-book"></i>
    <span class="pcoded-mtext">Settings</span>
</a>
       <ul class="pcoded-submenu">

                                <li class="{{ Route::is('reprint-admission-letter') ? 'active' : '' }}"><a
                                href="{{ route('reprint-admission-letter') }}">Reprint Summary</a></li>

                            <li class="{{ Route::is('set.agelimit-index') ? 'active' : '' }}"><a
                                    href="{{ route('set.agelimit-index') }}">Age Limit</a></li>
                            <li class="{{ Route::is('results.bece-results-index') ? 'active' : '' }}"><a
                                href="{{ route('results.bece-results-index') }}">Bece Results</a></li>
                        <li class="{{ Route::is('subject.bece-subject-index') ? 'active' : '' }}"><a
                                href="{{ route('subject.bece-subject-index') }}">Bece Subjects</a></li>
                        <li class="{{ Route::is('results.wassce-results-index') ? 'active' : '' }}"><a
                                href="{{ route('results.wassce-results-index') }}">Wassce Results</a></li>
                        <li class="{{ Route::is('subject.wassce-subject-index') ? 'active' : '' }}"><a
                                href="{{ route('subject.wassce-subject-index') }}">Wassce Subjects</a></li>

                                <li class="{{ Route::is('bran.branch-index') ? 'active' : '' }}"><a
                                    href="{{ route('bran.branch-index') }}">Branch</a></li>


                            <li class="{{ Route::is('branch-sub-index') ? 'active' : '' }}"><a
                                    href="{{ route('branch-sub-index') }}">Sub Branches</a></li>
                                    <li class="{{ Route::is('branch-sub-sub-index') ? 'active' : '' }}"><a
                                    href="{{ route('branch-sub-sub-index') }}">Sub Sub Branches</a></li>
        </ul>
        </li>





         @role('Academic')
                <li class="nav-item pcoded-menu-caption">
                    <label class="fs-4">Academics Panel</label>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('admin.courses') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-users"></i></span><span
                            class="pcoded-mtext">Progams</span></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.category') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-book"></i></span><span
                            class="pcoded-mtext">Courses</span></a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.course.packaging') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-box"></i></span><span
                            class="pcoded-mtext">Packages(courses)</span></a>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i  class="feather icon-book"></i></span><span class="pcoded-mtext">Assignments</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('admin.assignments') }}">Add/View Assignments</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i  class="feather icon-check"></i></span><span class="pcoded-mtext">Assessments</span></a>
                    <ul class="pcoded-submenu">
                        {{-- <li><a href="{{ route('admin.assignments.marks') }}">Assignments</a></li>
                        <li><a href="{{ route('admin.quizzes') }}">Quizzes</a></li>
                        <li><a href="{{ route('admin.exams') }}">Exams</a></li> --}}
                        <li><a href="{{ route('admin.scores') }}">Scores</a></li>
                    </ul>
                </li>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-box"></i></span><span class="pcoded-mtext">Report</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('admin.report.courses') }}">Courses</a></li>
                        <li><a href="{{ route('admin.report.assignments') }}">Assignments</a></li>
                        <li><a href="{{ route('admin.report.performance') }}">Performance</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-book"></i></span><span class="pcoded-mtext">Guide</span></a>
                </li>
@endrole
                @role('superadmin')
               <li class="nav-item pcoded-menu-caption">
                    <label class="fs-4">Users Panel</label>
                </li>

                <li
                    class="nav-item pcoded-hasmenu {{ Route::is('index-user', 'index-roles', 'user-audit-trail', 'login_and_logout','view-faculty','view-faculty-department') ? 'active' : '' }}">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-settings"></i></span><span class="pcoded-mtext">Account
                            Setting</span></a>
                    <ul class="pcoded-submenu">
                        <li class="{{ Route::is('index-user') ? 'active' : '' }}"><a
                                href="{{ route('index-user') }}">Users</a></li>

                                <li class="{{ Route::is('subject-allocation') ? 'active' : '' }}"><a
                                    href="{{ route('subject-allocation') }}">Subject Allocation</a></li>


                                <li class="{{ Route::is('view-faculty') ? 'active' : '' }}"><a
                                    href="{{ route('view-faculty') }}">Faculty</a></li>
                                    <li class="{{ Route::is('view-faculty-department') ? 'active' : '' }}"><a
                                        href="{{ route('view-faculty-department') }}">Department</a></li>

                        <li class="{{ Route::is('index-roles') ? 'active' : '' }}"><a
                                href="{{ route('index-roles') }}">Roles</a></li>
                        <li class="{{ Route::is('user-audit-trail') ? 'active' : '' }}"><a
                                href="{{ route('user-audit-trail') }}">Audit Trail</a></li>
                        <li class="{{ Route::is('login_and_logout') ? 'active' : '' }}"><a
                                href="{{ route('login_and_logout') }}">Actives Logs</a></li>
                    </ul>
                </li>
            @endrole
            </ul>
        </div>
    </div>
</nav>
