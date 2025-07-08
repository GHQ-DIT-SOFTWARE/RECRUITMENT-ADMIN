<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0,  minimal-ui">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link rel="icon" href="{{ asset('logo-icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />
    <style>
        /* Style for the dropdown menu */
        .dropdown-menu.notification {
            width: 350px; /* Adjust width as needed */
        }
        /* Ensure the list itself is scrollable when items exceed limit */
        .pro-body {
            max-height: 400px; /* Adjust to fit more notifications */
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden; /* Prevent horizontal scrolling */
            list-style: none;
            padding: 0;
            margin: 0;
        }
        /* Ensure text wraps and is fully visible */
        .dropdown-item a {
            display: block;
            white-space: normal; /* Allow text wrapping */
            word-wrap: break-word; /* Break long words */
            overflow: hidden;
        }
        /* Improve readability */
        .dropdown-item {
            padding: 10px;
            border-bottom: 1px solid #ddd; /* Separate each notification */
        }
        /* Remove border for the last item */
        .dropdown-item:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body class="">
    @include('admin.layout.nav')
    @include('admin.layout.header')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            {{-- #3d060c --}}
            @yield('content')
        </div>
    </div>

    <script src="{{asset('js/app.js') }}" defer></script>
    <script src="{{asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{asset('assets/js/ripple.js') }}"></script>
    <script src="{{asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{asset('assets/js/pages/dashboard-main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script src="{{asset('assets/js/plugins/ekko-lightbox.min.js') }}"></script>
    <script src="{{asset('assets/js/plugins/lightbox.min.js') }}"></script>
    <script src="{{asset('assets/js/pages/ac-lightbox.js') }}"></script>
    <script src="{{asset('assets/js/code.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript"src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript"src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript"src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript"src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript"src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript"src=" https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript"src=" https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('assets/js/plugins/isotope.pkgd.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>
</html>
