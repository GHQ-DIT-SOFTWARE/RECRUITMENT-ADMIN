@extends('admin.layout.master')
@section('title')
DASHBOARD
@endsection
@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Main</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">

            <marquee
                behavior="scroll"
                direction="left"
                scrollamount="6"
                style="background-color:#adb5bd; color: rgb(14, 12, 12); font-weight: bold; font-size: 2rem; padding: 10px;">
                @auth {{ Auth::user()->name }} @endauth,WELCOME TO GAF RECRUITMENT ADMIN PORTAL.
            </marquee>

            <div style="display: flex; justify-content: center; align-items: center;">
                <img src="{{ asset('recruitment_admin.jpg') }}"  alt="" class="img-fluid">
            </div>
        </div>

@endsection
