@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Contact</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="contact-form p-4 border rounded shadow-sm bg-light">
                        <h4 class="mb-4" style="color: #d92228;">Get in Touch</h4>
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Name *</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Your full name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email *</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label fw-semibold">Message *</label>
                                <textarea id="message" name="message" class="form-control" rows="4" placeholder="Write your message here...">{{ old('message') }}</textarea>
                                @error('message')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary bg-website">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="map" style="height: 100%">
                        <iframe style="height: 100%" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2799198932!2d-74.25987701513004!3d40.69767006272707!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1645362221879!5m2!1sen!2sbd" width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
