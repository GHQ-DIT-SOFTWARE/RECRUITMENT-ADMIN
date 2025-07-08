<!DOCTYPE html>
<html lang="en">

<head>
    <title>Verify OTP|{{ config('app.name') }}</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
     <link rel="icon" href="{{ asset('nursingschoollogo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<div class="auth-wrapper">
    <div class="auth-content">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="mb-3 f-w-400">Enter OTP</h4>
                        @if ($errors->has('phone_number'))
                            <div class="alert alert-danger">
                                {{ $errors->first('phone_number') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('otp.verify') }}">
                            @csrf
                            <div class="form-group mb-4">
                                {{-- <label for="otp_code">Enter OTP:</label> --}}
                                <input type="text" id="otp_code" name="otp_code" class="form-control" required>
                                @error('otp_code')
                                    <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-block btn-primary mb-4">Verify</button>
                        </form>
                        @if ($errors->any() && !$errors->has('phone_number'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
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
