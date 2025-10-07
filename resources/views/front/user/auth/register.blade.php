@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>User Registration</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h4 class="mb-4 text-center">Create Your Account</h4>
                            <form action="{{ route('user.register.submit') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone Number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">09</span>
                                        <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password *</label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password *</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary bg-website">
                                        <i class="fas fa-user-plus me-2"></i> Create Account
                                    </button>
                                </div>
                            </form>

                            <div class="text-center">
                                <a href="{{ route('user.login') }}" class="text-decoration-none text-muted">
                                    Already registered? <strong>Login here</strong>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
