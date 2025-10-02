@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Agent</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.agents.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.agents.update', $agent) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="">Existing Photo</label>
                                            <div class="form-group">
                                                <img src="{{ $agent->photo ? asset('user-images/' . $agent->photo) : asset('user-images/default.png') }}" alt="Agent-image" class="user-photo w_200">
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
                                                <input type="text" name="name" class="form-control" value="{{ $agent->name }}">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Email *</label>
                                            <div class="form-group">
                                                <input type="text" name="email" class="form-control" value="{{ $agent->email }}">
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
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
                                            <label class="form-label" for="">Company *</label>
                                            <div class="form-group">
                                                <input type="text" name="company" class="form-control" value="{{ $agent->company }}">
                                                @error('company')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Phone Number *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">09</span>
                                                <input type="tel" name="phone" class="form-control" value="{{ substr($agent->phone, 2) }}">
                                            </div>
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Designation *</label>
                                            <div class="form-group">
                                                <input type="text" name="designation" class="form-control" value="{{ $agent->designation }}">
                                                @error('designation')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Address</label>
                                            <div class="form-group">
                                                <input type="text" name="address" class="form-control" value="{{ $agent->address }}">
                                                @error('address')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Country</label>
                                            <div class="form-group">
                                                <input type="text" name="country" class="form-control" value="{{ $agent->country }}">
                                                @error('country')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">State</label>
                                            <div class="form-group">
                                                <input type="text" name="state" class="form-control" value="{{ $agent->state }}">
                                                @error('state')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">City</label>
                                            <div class="form-group">
                                                <input type="text" name="city" class="form-control" value="{{ $agent->city }}">
                                                @error('city')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Website</label>
                                            <div class="form-group">
                                                <input type="text" name="website" class="form-control" value="{{ $agent->website }}">
                                                @error('website')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Facebook</label>
                                            <div class="form-group">
                                                <input type="text" name="facebook" class="form-control" value="{{ $agent->facebook }}">
                                                @error('facebook')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Twitter</label>
                                            <div class="form-group">
                                                <input type="text" name="twitter" class="form-control" value="{{ $agent->twitter }}">
                                                @error('twitter')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Linkedin</label>
                                            <div class="form-group">
                                                <input type="text" name="linkedin" class="form-control" value="{{ $agent->linkedin }}">
                                                @error('linkedin')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="">Instagram</label>
                                            <div class="form-group">
                                                <input type="text" name="instagram" class="form-control" value="{{ $agent->instagram }}">
                                                @error('instagram')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="">Status *</label>
                                            <div class="form-group">
                                                <select name="status" class="form-control">
                                                    <option @selected($agent->getRawOriginal('status') == '0') value="0">Inactive</option>
                                                    <option @selected($agent->getRawOriginal('status') == '1') value="1">Active</option>
                                                    <option @selected($agent->getRawOriginal('status') == '2') value="2">Suspended</option>
                                                </select>
                                                @error('status')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="">Biography</label>
                                            <div class="form-group">
                                                <textarea name="biography" class="form-control h_200" rows="5">{{ $agent->biography }}</textarea>
                                                @error('biography')
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
