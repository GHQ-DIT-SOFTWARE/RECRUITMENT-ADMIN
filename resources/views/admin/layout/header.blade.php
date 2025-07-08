<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        <a href="#!" class="mob-toggler">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <!-- Notification Dropdown -->
            {{-- <li class="nav-item dropdown">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="feather icon-bell"></i>
                    <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                    <!-- Unread Notifications Count -->
                </a>
                <div class="dropdown-menu dropdown-menu-right notification">
                    <ul class="pro-body">
                        @forelse (auth()->user()->unreadNotifications as $notification)
                            <li class="dropdown-item">
                                <a href="{{ route('notifications.read', $notification->id) }}">
                                    <!-- Route to mark notification as read -->
                                    <i class="feather icon-info"></i>
                                    {{ $notification->data['message'] }} <!-- Display notification message -->
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        @empty
                            <li class="dropdown-item">
                                <a href="#">No new notifications</a>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </li> --}}
@role('Admission')
 <li class="nav-item dropdown">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="feather icon-bell"></i>
                    <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right notification">
                    <ul class="pro-body">
                        @forelse (auth()->user()->unreadNotifications as $notification)
                            <li class="dropdown-item">
                                <a href="{{ route('notifications.read', $notification->id) }}">
                                    <i class="feather icon-info"></i>
                                    {{ $notification->data['message'] }} <!-- Notification message -->
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        @empty
                            <li class="dropdown-item">
                                <a href="#">No new notifications</a>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </li>

@endrole

            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="feather icon-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-notification">
                    <div class="pro-head">
                        <img src="{{ asset('gafnursingandmidfery.png') }}" class="img-radius" alt="User-Profile-Image">
                        <span>{{ Auth::user()->name }}</span>
                        {{-- <a href="{{ route('logout') }}" class="dud-logout" title="Logout">
                            <i class="feather icon-log-out"></i>
                        </a> --}}
                    </div>
                    <ul class="pro-body">
                        <li><a href="{{ route('profile.index') }}" class="dropdown-item"><i
                                    class="feather icon-user"></i> Profile</a></li>
                        <li><a href="{{ route('logout') }}" class="dropdown-item"> <i class="feather icon-log-out"></i>
                                Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</header>
