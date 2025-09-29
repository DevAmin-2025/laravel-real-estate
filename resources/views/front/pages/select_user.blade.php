@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Select User</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Customer Card -->
                <div class="col-md-5 mb-4">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <i class="fas fa-user fa-2x mb-3 text-primary"></i>
                            <h5 class="card-title mb-4">Customer</h5>
                            <a href="{{ route('user.register') }}" class="btn btn-outline-primary mb-2 w-75 mx-auto">Registration</a>
                            <a href="{{ route('user.login') }}" class="btn btn-primary w-75 mx-auto">Login</a>
                        </div>
                    </div>
                </div>

                <!-- Agent Card -->
                <div class="col-md-5 mb-4">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <i class="fas fa-user-tie fa-2x mb-3 text-success"></i>
                            <h5 class="card-title mb-4">Agent</h5>
                            <a href="" class="btn btn-outline-success mb-2 w-75 mx-auto">Registration</a>
                            <a href="" class="btn btn-success w-75 mx-auto">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
