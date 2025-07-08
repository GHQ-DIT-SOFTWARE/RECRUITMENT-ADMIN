@extends('admin.layout.master')
@section('title')
Account-Dashboard
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-footer {
            transition: background-color 0.3s ease;
        }

        .card:hover .card-footer.bg-c-green {
            background-color: #28a745 !important;
        }

        .card:hover .card-footer.bg-c-yellow {
            background-color: #ffc107 !important;
        }

        .card:hover .card-footer.bg-c-red {
            background-color: #dc3545 !important;
        }

        .widget-visitor-card:hover {
            animation: pulseGlow 1s infinite alternate;
        }

        @keyframes pulseGlow {
            from {
                box-shadow: 0 0 0 rgba(0, 0, 0, 0.1);
            }
            to {
                box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            }
        }
    </style>


    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                       <h5 class="m-b-10">Account</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-8">
                    <h4 class="text-c-green"></h4>
                    <h6 class="text-muted m-b-0">GHS</h6>
                </div>
                <div class="col-4 text-right">
                    <i class="fa fa-money-bill-wave f-28"></i>
                </div>
            </div>
        </div>
        <div class="card-footer bg-c-white">
            <div class="row align-items-center">
                <div class="col-9">
                    <p class="text-black m-b-0"><b><i>Account Balance</i></b></p>
                </div>
            </div>
        </div>
    </div>
</div>
  <div class="col-lg-6 col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-8">
                    <h4 class="text-c-green"></h4>
                    <h6 class="text-muted m-b-0">GHS</h6>
                </div>
                <div class="col-4 text-right">
                    <i class="fa fa-money-bill-wave f-28"></i>
                </div>
            </div>
        </div>
        <div class="card-footer bg-c-white">
            <div class="row align-items-center">
                <div class="col-9">
                    <p class="text-black m-b-0"><b><i>Account Balance</i></b></p>
                </div>
            </div>
        </div>
    </div>
</div>
  <div class="col-lg-6 col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-8">
                    <h4 class="text-c-green"></h4>
                    <h6 class="text-muted m-b-0">GHS</h6>
                </div>
                <div class="col-4 text-right">
                    <i class="fa fa-money-bill-wave f-28"></i>
                </div>
            </div>
        </div>
        <div class="card-footer bg-c-white">
            <div class="row align-items-center">
                <div class="col-9">
                    <p class="text-black m-b-0"><b><i>Account Balance</i></b></p>
                </div>
            </div>
        </div>
    </div>
</div>
  <div class="col-lg-6 col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-8">
                    <h4 class="text-c-green"></h4>
                    <h6 class="text-muted m-b-0">GHS</h6>
                </div>
                <div class="col-4 text-right">
                    <i class="fa fa-money-bill-wave f-28"></i>
                </div>
            </div>
        </div>
        <div class="card-footer bg-c-white">
            <div class="row align-items-center">
                <div class="col-9">
                    <p class="text-black m-b-0"><b><i>Account Balance</i></b></p>
                </div>
            </div>
        </div>
    </div>
</div>

 </div>


@endsection
