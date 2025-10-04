@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Edit Header</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.header.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-3">
                                        <label class="from-label">Existing Photo</label>
                                        <div>
                                            <img src="{{ asset('website-images/' . $header->photo) }}" alt="Header-image" class="w_200">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="from-label">Change Photo</label>
                                        <div>
                                            <input type="file" name="photo">
                                            @error('photo')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="from-label">Title *</label>
                                        <input type="text" class="form-control" name="title" value="{{ ucwords($header->title) }}">
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="from-label">Text *</label>
                                        <input type="text" class="form-control" name="text" value="{{ $header->text }}">
                                        @error('text')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
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
