@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Plan</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left m-2"></i>Back</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Name *</label>
                                                <input type="text" class="form-control" name="name" value="{{ $plan->name }}">
                                                @error('name')
                                                    <small class="text-danger small">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Price *</label>
                                                <input type="text" class="form-control" name="price" value="{{ number_format($plan->price) }}">
                                                @error('price')
                                                    <small class="text-danger small">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Allowed Days *</label>
                                                <input type="text" class="form-control" name="allowed_days" value="{{ $plan->allowed_days }}">
                                                @error('allowed_days')
                                                    <small class="text-danger small">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Allowed Properties *</label>
                                                <input type="text" class="form-control" name="allowed_properties" value="{{ $plan->allowed_properties }}">
                                                @error('allowed_properties')
                                                    <small class="text-danger small">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Allowed Featured Properties *</label>
                                                <input type="text" class="form-control" name="allowed_featured_properties" value="{{ $plan->allowed_featured_properties }}">
                                                @error('allowed_featured_properties')
                                                    <small class="text-danger small">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Allowed Photos *</label>
                                                <input type="text" class="form-control" name="allowed_photos" value="{{ $plan->allowed_photos }}">
                                                @error('allowed_photos')
                                                    <small class="text-danger small">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>Allowed Videos *</label>
                                                <input type="text" class="form-control" name="allowed_videos" value="{{ $plan->allowed_videos }}">
                                                @error('allowed_videos')
                                                    <small class="text-danger small">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
