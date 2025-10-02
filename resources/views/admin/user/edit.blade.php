@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit User</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="">Existing Photo</label>
                                            <div class="form-group">
                                                <img src="{{ $user->photo ? asset('user-images/' . $user->photo) : asset('user-images/default.png') }}" alt="User-image" class="user-photo w_200">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="">Change Photo</label>
                                            <div class="form-group">
                                                <input type="file" name="photo">
                                                @error('photo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Name *</label>
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Email *</label>
                                            <div class="form-group">
                                                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">09</span>
                                                <input type="tel" name="phone" class="form-control" value="{{ substr($user->phone, 2) }}">
                                            </div>
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Password</label>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Confirm Password</label>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype new password">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Status *</label>
                                            <div class="form-group">
                                                <select name="status" class="form-control">
                                                    <option @selected($user->getRawOriginal('status') == '0') value="0">Inactive</option>
                                                    <option @selected($user->getRawOriginal('status') == '1') value="1">Active</option>
                                                    <option @selected($user->getRawOriginal('status') == '2') value="2">Suspended</option>
                                                </select>
                                                @error('status')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Update">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
