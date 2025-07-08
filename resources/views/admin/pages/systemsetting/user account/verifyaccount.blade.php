<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <link rel="icon" href="{{ asset('assets/images/LOGO-ICON.PNG  ') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<!-- [ offline-ui ] start -->
<div class="auth-wrapper maintance">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center">
                    <img src="{{ asset('assets/images/maintance/maintance.png') }}" alt="" class="img-fluid">
                    @if (session('expired'))
                        <h5 class="text-danger my-4">Password has expired. Please create a new password.</h5>
                    @elseif(session('first_login'))
                        <h5 class="text-muted my-4">Please change your default password.</h5>
                    @else
                        <h5 class="text-muted my-4">Please change your password to get access to the portal.</h5>
                    @endif
                    <div class="card">
                        <form method="POST" action="{{ route('changed-password') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password">New Password</label>
                                    <input id="password" type="password" name="password" required
                                        autocomplete="new-password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        required autocomplete="new-password">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>

</body>

</html>
