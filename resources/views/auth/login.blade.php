<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <title>ADMIN | {{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <!-- Favicon icon -->
       <link rel="icon" href="{{ asset('logo-icon.png') }}" type="image/x-icon">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
 <style>
/* Full height container to center content vertically */
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
}
.auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}
/* Responsive content box */
.auth-content {
    width: 90%;
    max-width: 370px;
    padding: 1.5rem;
    box-sizing: border-box;
    border-radius: 8px;
}
/* Tweak padding for smaller screens */
@media (max-width: 480px) {
    .auth-content {
        padding: 1rem;
    }
}
</style>
</head>
<!-- [ signin-img ] start -->
<div class="auth-wrapper align-items-stretch aut-bg-img">
    <div class="flex-grow-1">
        <div class="auth-side-form">
            <div class="auth-content">
                    @if (session('success'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('success') }}
                    </div>
                @elseif (session('info'))
                    <div class="alert alert-info mt-3" role="alert">
                        {{ session('info') }}
                    </div>
                @elseif ($errors->has('error'))
                    <div class="alert alert-danger mt-3" role="alert">
                        {{ $errors->first('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <h3 class="mb-4 f-w-400">Signin</h3>
                    <div class="form-group mb-3">
                        <label class="floating-label" for="Email">Email address</label>
                        <input type="text" class="form-control" id="Email" name="email" placeholder="">
                        @error('email')
                            <span class="badge badge-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="floating-label" for="Password">Password</label>
                        <input type="password" class="form-control" id="Password" name="password" placeholder="">
                        @error('password')
                            <span class="badge badge-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button class="btn btn-block btn-primary mb-4">Signin</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/ripple.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
</body>

</html>
