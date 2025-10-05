@extends('front.layouts.master')
@section('content')
    <div class="slider" style="background-image: url({{ asset('website-images/' . $header->photo) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="item">
                        <div class="text">
                            <h2>{{ $header->title }}</h2>
                            <p>{{ $header->text }}</p>
                        </div>
                        <div class="search-section">
                            <form action="{{ route('properties') }}" method="GET">
                                <div class="inner">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input type="text" name="title" class="form-control" placeholder="Find Anything ...">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <select name="location_id" class="form-control select2">
                                                    <option selected disabled>Select Location</option>
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <select name="type_id" class="form-control select2">
                                                    <option selected disabled>Select Type</option>
                                                    @foreach ($propertyTypes as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="property">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Properties</h2>
                        <p>Find out the awesome properties that you must love</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($randomProperties as $property)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="item">
                            <div class="photo">
                                <img class="main" src="{{ asset('property-images/' . $property->featured_photo) }}" alt="Property-image">
                                <div class="top">
                                    <div class="{{ $property->purpose == 'For Sale' ? 'status-sale' : 'status-rent'}}">
                                        {{ $property->purpose }}
                                    </div>
                                </div>
                                <div class="price">${{ number_format($property->price) }}</div>
                                <div class="wishlist">
                                    @php
                                        $loggedIn = Auth::guard('web')->check();
                                        if ($loggedIn) {
                                            $user = Auth::guard('web')->user()->load('wishlist');
                                            $hasWishlisted = $user->hasWishlisted($property);
                                            $wishlistItem = $user->wishlist->firstWhere('property_id', $property->id);
                                        };
                                    @endphp
                                    @if (!$loggedIn || !$hasWishlisted)
                                        <a href="{{ route('user.add.to.wishlist', $property) }}"><i class="far fa-heart"></i></a>
                                    @else
                                        <form action="{{ route('user.remove.from.wishlist', $wishlistItem) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background: transparent;">
                                                <i class="fas fa-heart" style="color: #d92228;">
                                                </i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="text">
                                <h3><a href="{{ route('property.detail', $property->slug) }}">{{ $property->name }}</a></h3>
                                <div class="detail">
                                    <div class="stat">
                                        <div class="i1">{{ $property->size }} sqft</div>
                                        <div class="i2">{{ $property->bedroom }} Bedroom(s)</div>
                                        <div class="i3">{{ $property->bathroom }} Bathroom(s)</div>
                                    </div>
                                    <div class="address">
                                        <i class="fas fa-map-marker-alt"></i> {{ $property->address }}
                                    </div>
                                    <div class="type-location">
                                        <div class="i1">
                                            <i class="fas fa-edit"></i> {{ $property->propertyType->name }}
                                        </div>
                                        <div class="i2">
                                            <i class="fas fa-location-arrow"></i> {{ $property->location->name }}
                                        </div>
                                    </div>
                                    <div class="agent-section">
                                        <img class="agent-photo" src="{{ $property->agent->photo ? asset('user-images/' . $property->agent->photo) : asset('user-images/default.png') }}" alt="Agent-image">
                                        <a href="{{ route('agent.detail', $property->agent) }}">{{ $property->agent->name }} ({{ $property->agent->company }})</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="why-choose" style="background-image: url({{ asset('website-images/why-choose.jpg') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Why Choose Us</h2>
                        <p>
                            Describing why we are best in the property business
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($whyChooseUsItems as $item)
                    <div class="col-md-4">
                        <div class="inner">
                            <div class="icon">
                                <i class="{{ $item->icon }}"></i>
                            </div>
                            <div class="text">
                                <h2>{{ $item->title }}</h2>
                                <p>{{ $item->text }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="agent">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Agents</h2>
                        <p>
                            Meet our expert property agents from the following list
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($agents as $agent)
                    <div class="col-lg-3 col-md-3">
                        <div class="item">
                            <div class="photo">
                                <a href="{{ route('agent.detail', $agent) }}">
                                    <img src="{{ $agent->photo ? asset('user-images/' . $agent->photo) : asset('user-images/default.png') }}" alt="Agent-image">
                                </a>
                            </div>
                            <div class="text">
                                <h2>
                                    <a href="{{ route('agent.detail', $agent) }}">{{ $agent->name }}</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="location pb_40">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Locations</h2>
                        <p>
                            Check out all the properties of important locations
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($popularLocations as $location)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="item">
                            <div class="photo">
                                <a href="{{ route('location.detail', $location->slug) }}"><img src="{{ asset('location-images/' . $location->photo) }}" alt="Location-image"></a>
                            </div>
                            <div class="text">
                                <h2><a href="{{ route('location.detail', $location->slug) }}">{{ $location->name }}</a></h2>
                                <h4>({{ $location->properties_count }} Properties)</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="testimonial" style="background-image: url({{ asset('website-images/testimonial-bg.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="main-header">Our Happy Clients</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-carousel owl-carousel">
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="photo">
                                    <img src="{{ asset('user-images/' . $testimonial->photo) }}" alt="User-image"/>
                                </div>
                                <div class="text">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <p>{{ $testimonial->designation }}</p>
                                </div>
                                <div class="description">
                                    <p>
                                        {{ $testimonial->comment }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Latest News</h2>
                        <p>
                            Check our latest news from the following section
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="item border rounded">
                            <div class="photo">
                                <img src="{{ asset('blog-images/' . $post->photo) }}" alt="Post-image"/>
                            </div>
                            <div class="text p_10">
                                <h2>
                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <div class="short-des" style="height: 150px">
                                    <p>{{ $post->short_description }}</p>
                                </div>
                                <div class="button ">
                                    <a href="{{ route('post', $post->slug) }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
