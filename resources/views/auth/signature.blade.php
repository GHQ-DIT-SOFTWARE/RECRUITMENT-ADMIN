<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Signature | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="{{ asset('logo-icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

<div class="auth-wrapper maintance">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center">
                    <h4 class="mb-4 ">Upload Your Signature</h4>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

<div class="card p-4">
    <form method="POST" action="{{ route('signature.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="signature">Select Signature Image <small>(PNG or JPG only)</small></label>
            <input type="file" class="form-control-file" name="signature" id="signature" required accept="image/png,image/jpeg">
        </div>

        <!-- Image preview container -->
        <div id="preview-container" style="margin-top: 15px; display: none;">
            <h5>Image Preview:</h5>
            <img id="image-preview" src="#" alt="Signature Preview" style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Upload Signature</button>
    </form>

    @if(Auth::user()->signature)
        <div class="mt-4">
            <h5>Your uploaded signature:</h5>
            <img src="{{ asset(Auth::user()->signature) }}" alt="Signature Image" style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
        </div>
    @endif
</div>




                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('signature').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('image-preview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            previewImage.src = '#';
            previewContainer.style.display = 'none';
        }
    });
</script>
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
</body>
</html>
