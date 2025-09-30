@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Edit Profile</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content user-panel">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <x-dashboard/>
                </div>
                <div class="col-lg-9 col-md-12">
                    <form action="{{ route('user.edit.profile.submit', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Current Photo</label>
                                <div class="mb-3">
                                    <img src="{{ $user->photo ? asset('user-images/' . $user->photo) : asset('user-images/default.png') }}"
                                        alt="User-image"
                                        class="img-thumbnail rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="photo" class="form-label">Upload New Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control">
                                @error('photo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repeat new password">
                            </div>
                            <div class="col-md-12">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <div class="input-group">
                                    <span class="input-group-text">09</span>
                                    <input type="tel" name="phone" class="form-control" value="{{ substr($user->phone, 2) }}">
                                </div>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-12 text-end">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary px-4" value="Update Profile">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
