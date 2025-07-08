@extends('admin.layout.master')
@section('title')
    Analysis Dashboard
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
                       <h5 class="m-b-10">Analytical</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">{{ $total_applicants }}</h4>
                            <h6 class="text-muted m-b-0">TOTAL</h6>
                        </div>
                        <div class="col-4 text-right">
                           <i class="feather icon-user f-28"></i>

                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-white">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-black m-b-0"><b><i>APPLICANTS</i></b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">{{ $qualified_bsc_midwifery}}</h4>
                            <h6 class="text-muted m-b-0">TOTAL</h6>
                        </div>
                        <div class="col-4 text-right">
                          <i class="feather icon-user f-28"></i>

                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-white">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-black m-b-0"><b><i>BSC MIDWIFERY</i></b></p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-up text-white f-16"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">{{ $qualified_bsc_nursing }}</h4>
                            <h6 class="text-muted m-b-0">TOTAL</h6>
                        </div>
                        <div class="col-4 text-right">
                          <i class="feather icon-user f-28"></i>

                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-white">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-black m-b-0"><b><i>BSC NURSING</i></b></p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-up text-white f-16"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">{{ $incomplete_applications }}</h4>
                            <h6 class="text-muted m-b-0">TOTAL</h6>
                        </div>
                        <div class="col-4 text-right">
                          <i class="feather icon-user f-28"></i>

                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-white">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-black m-b-0"><b><i>INCOMPLETE APP</i></b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-xl-3 col-md-12">
            <div class="card bg-c-yellow text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $total_qualified_courses }}</h2>
                    <h6 class="text-white">TOTAL QUALIFIED APPLICANTS</h6>
                    <i class="feather icon-file-text"></i>
                </div>
            </div>


        </div>

        <div class="col-xl-3 col-md-12">
            <div class="card bg-c-red text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $total_disqualified_courses }}</h2>
                    <h6 class="text-white">TOTAL DISQUALIFIED APPICANTS</h6>
                    <i class="feather icon-award"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12">
            <div class="card bg-c-yellow text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $top_up }}</h2>
                    <h6 class="text-white">TOTAL TOP UP</h6>
                    <i class="feather icon-file-text"></i>
                </div>
            </div>


        </div>

        <div class="col-xl-3 col-md-12">
            <div class="card bg-c-red text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $regular }}</h2>
                    <h6 class="text-white">TOTAL REGULAR</h6>
                    <i class="feather icon-award"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <a href="{{ route('document.master-filter-documentation') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted m-b-1">RESULTS VERIFICATION</h6>
                                <h5 class="text-c-green mb-1">QUALIFIED: {{ $qualified_results_verification }}</h5>
                                <h5 class="text-c-red">DISQUALIFIED: {{ $disqualified_results_verification }}</h5>
                            </div>
                            <div class="col-4 text-right">
                              <i class="feather icon-user f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-white">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-black m-b-0">View Details</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('test.master-filter-aptitude') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted m-b-1">APTITUDE TEST</h6>
                                <h5 class="text-c-green mb-1">QUALIFIED: {{ $qualified_aptitude }}</h5>
                                <h5 class="text-c-red">DISQUALIFIED: {{ $disqualified_aptitude }}</h5>
                            </div>
                            <div class="col-4 text-right">
                              <i class="feather icon-user f-28"></i>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-white">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-black m-b-0">View Details</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="{{ route('test.master-filter-interview') }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted m-b-1">INTERVIEW</h6>
                                <h5 class="text-c-green mb-1">QUALIFIED: {{ $qualified_results_verification }}</h5>
                                <h5 class="text-c-red">DISQUALIFIED: {{ $disqualified_results_verification }}</h5>
                            </div>
                            <div class="col-4 text-right">
                               <i class="feather icon-user f-28"></i>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-white">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-black m-b-0">View Details</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('applicantsChart').getContext('2d');
        const chartData = @json($chartData);
        new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });
    </script>
@endsection
