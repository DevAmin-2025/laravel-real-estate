@extends('front.layouts.master')
    @section('content')
    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Create Message</h2>
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
                    <a href="{{ route('user.messages.index') }}" class="btn btn-primary btn-sm mb_10">Back</a>
                    <form action="{{ route('user.messages.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Subject *</label>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                                @error('subject')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message *</label>
                            <div class="form-group">
                                <textarea name="message" class="form-control h-200">{{ old('message') }}</textarea>
                                @error('message')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Agent *</label>
                            <div class="form-group">
                                <select name="agent_id" class="form-select select2">
                                    <option selected disabled>-- Select --</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected(old('agent_id') == $agent->id)>{{ $agent->name }}, {{ $agent->company }}</option>
                                    @endforeach
                                </select>
                                @error('agent_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
