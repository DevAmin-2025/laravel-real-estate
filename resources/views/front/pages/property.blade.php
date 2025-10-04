@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $property->name }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="property-result">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="left-item">
                        <div class="main-photo">
                            <img src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image">
                        </div>
                        <h2>
                            Description
                        </h2>
                        @if ($property->description)
                            <p>{{ $property->description }}</p>
                        @else
                            <span class="text-danger">No description available</span>
                        @endif
                    </div>
                    <div class="left-item">
                        <h2>
                            Photos
                        </h2>
                        @if ($property->photos->isNotEmpty())
                            <div class="photo-all">
                                <div class="row">
                                    @foreach ($property->photos as $photo)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="item">
                                                <a href="{{ asset('property-images/' . $photo->photo) }}" class="magnific">
                                                    <img src="{{ asset('property-images/' . $photo->photo) }}" alt="Property-image" />
                                                    <div class="icon">
                                                        <i class="fas fa-plus"></i>
                                                    </div>
                                                    <div class="bg"></div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <span class="text-danger">No photos available</span>
                        @endif
                    </div>
                    <div class="left-item">
                        <h2>
                            Videos
                        </h2>
                        @if ($property->videos->isNotEmpty())
                            <div class="video-all">
                                <div class="row">
                                    @foreach ($property->videos as $video)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="item">
                                                <a class="video-button" href="http://www.youtube.com/watch?v={{ $video->video }}">
                                                    <img src="http://img.youtube.com/vi/{{ $video->video }}/.jpg" alt="Property-video"/>
                                                    <div class="icon">
                                                        <i class="far fa-play-circle"></i>
                                                    </div>
                                                    <div class="bg"></div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <span class="text-danger">No videos available</span>
                        @endif
                    </div>

                    <div class="left-item mb_50">
                        <h2>Share</h2>
                        @php
                            $url = url('property/' . $property->slug);
                        @endphp
                        <div class="share">
                            <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" target="_blank">
                                Facebook
                            </a>
                            <a class="twitter" href="https://twitter.com/share?url={{ urlencode($url) }}" target="_blank">
                                Twitter
                            </a>
                            <a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($url) }}" target="_blank">
                                LinkedIn
                            </a>
                        </div>
                    </div>

                    <div class="left-item">
                        <h2>
                            Related Properties
                        </h2>
                        @if ($relatedProperties->isNotEmpty())
                            <div class="property related-property pt_0 pb_0">
                                <div class="row">
                                    @foreach ($relatedProperties as $relatedProperty)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="item">
                                                <div class="photo">
                                                    <img class="main" src="{{ asset('property-images/' . $relatedProperty->featured_photo) }}" alt="Property-image">
                                                    <div class="top">
                                                        <div class="{{ $relatedProperty->purpose == 'For Sale' ? 'status-sale' : 'status-rent'}}">
                                                                {{ $relatedProperty->purpose }}
                                                        </div>
                                                        @if ($relatedProperty->is_featured)
                                                            <div class="featured">
                                                                Featured
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="price">${{ number_format($relatedProperty->price) }}</div>
                                                    <div class="wishlist"><a href=""><i class="far fa-heart"></i></a></div>
                                                </div>
                                                <div class="text">
                                                    <h3><a href="{{ route('property.detail', $relatedProperty->slug)}}">{{ $relatedProperty->name }}</a></h3>
                                                    <div class="detail">
                                                        <div class="stat">
                                                            <div class="i1">{{ $relatedProperty->size }} sqft</div>
                                                            <div class="i2">{{ $relatedProperty->bedroom }} Bedroom(s)</div>
                                                            <div class="i3">{{ $relatedProperty->bathroom }} Bathroom(s)</div>
                                                        </div>
                                                        <div class="address">
                                                            <i class="fas fa-map-marker-alt"></i> {{ $relatedProperty->address }}
                                                        </div>
                                                        <div class="type-location">
                                                            <div class="i1">
                                                                <i class="fas fa-edit"></i> {{ $relatedProperty->propertyType->name }}
                                                            </div>
                                                            <div class="i2">
                                                                <i class="fas fa-location-arrow"></i> {{ $relatedProperty->location->name }}
                                                            </div>
                                                        </div>
                                                        <div class="agent-section">
                                                            <img class="agent-photo" src="{{ $relatedProperty->agent->photo ? asset('user-images/' . $relatedProperty->agent->photo) : asset('user-images/default.png') }}" alt="Agent-image">
                                                            <a href="{{ route('agent.detail', $relatedProperty->agent) }}">{{ $relatedProperty->agent->name }} ({{ $relatedProperty->agent->company }})</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <span class="text-danger">No related property available</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="right-item">
                        <h2>Agent</h2>
                        <div class="agent-right d-flex justify-content-start">
                            <div class="left">
                                <img src="{{ $property->agent->photo ? asset('user-images/' . $property->agent->photo) : asset('user-images/default.png') }}" alt="Agent-image">
                            </div>
                            <div class="right">
                                <h3><a href="{{ route('agent.detail', $property->agent) }}">{{ $property->agent->name }}</a></h3>
                                <h4>{{ $property->agent->designation }}</h4>
                            </div>
                        </div>
                        <div class="table-responsive mt_25">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Posted On: </td>
                                    <td>{{ $property->created_at->format('d M, Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Email: </td>
                                    <td>
                                        <a href="mailto:{{ $property->agent->email }}" style="color: inherit;">{{ $property->agent->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone: </td>
                                    <td>{{ $property->agent->phone }}</td>
                                </tr>
                                @if ($property->agent->website)
                                    <tr>
                                        @php
                                            $website = Str::startsWith($property->agent->website, ['http://', 'https://'])
                                                ? $property->agent->website
                                                : 'https://' . $property->agent->website;
                                        @endphp
                                        <td>Website:</td>
                                        <td><a href="{{ $website }}" target="_blank" style="color: inherit;">{{ $website }}</a></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Social: </td>
                                    <td>
                                        @php
                                            $hasSocial = $property->agent->facebook
                                                || $property->agent->twitter
                                                || $property->agent->instagram
                                                || $property->agent->linkedin;
                                        @endphp
                                        @if ($hasSocial)
                                            <ul class="agent-ul">
                                                @if ($property->agent->facebook)
                                                    <li><a href="{{ $property->agent->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                                @endif
                                                @if ($property->agent->twitter)
                                                    <li><a href="{{ $property->agent->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                                @endif
                                                @if ($property->agent->instagram)
                                                    <li><a href="{{ $property->agent->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                                @endif
                                                @if ($property->agent->linkedin)
                                                    <li><a href="{{ $property->agent->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                                @endif
                                            </ul>
                                        @else
                                            <span>No social media available</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="right-item">
                        <h2>Features</h2>
                        <div class="summary">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><b>Price</b></td>
                                        <td>${{ number_format($property->price) }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Location</b></td>
                                        <td>{{ $property->location->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Type</b></td>
                                        <td>{{ $property->propertyType->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Status</b></td>
                                        <td>{{ $property->purpose }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Bedroom:</b></td>
                                        <td>{{ $property->bedroom ? $property->bedroom : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Bathroom:</b></td>
                                        <td>{{ $property->bathroom ? $property->bathroom : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Size:</b></td>
                                        <td>{{ number_format($property->size) }} sqft</td>
                                    </tr>
                                    <tr>
                                        <td><b>Floor:</b></td>
                                        <td>{{ $property->floor ? number_format($property->floor) : 'Not Available' }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Garage:</b></td>
                                        <td>{{ $property->garage ? $property->garage : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Balcony:</b></td>
                                        <td>{{ $property->balcony ? $property->balcony : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Address:</b></td>
                                        <td>{{ $property->address }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Built Year:</b></td>
                                        <td>{{ $property->built_year ? $property->built_year : 'Not Available' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="right-item">
                        <h2>Amenities</h2>
                        @if ($property->amenities->isNotEmpty())
                            <div class="amenity">
                                <ul class="amenity-ul">
                                    @foreach ($property->amenities as $amenity)
                                        <li><i class="fas fa-check-square"></i> {{ $amenity->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <span class="text-danger">No Amenities Available</span>
                        @endif
                    </div>

                    <div class="right-item">
                        <h2>Location Map</h2>
                        @if ($property->map)
                            <div class="location-map">
                                <iframe src="{{ $property->map }}" width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        @else
                            <span class="text-danger">No Location Available</span>
                        @endif
                    </div>
                    <div class="right-item">
                        <h2 class="mb-4">Inquiry Form</h2>
                        <div class="enquery-form">
                            <form action="{{ route('property.inquiry.submit', $property) }}" method="POST" class="p-4 border rounded shadow-sm bg-light">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Full Name">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="tel" name="phone" class="form-control" placeholder="Phone Number">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <textarea name="message" class="form-control" rows="4" placeholder="Your Message"></textarea>
                                    @error('message')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        Submit Inquiry
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
