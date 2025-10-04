@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Properties</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="property-result">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="property-filter">
                        <form action="{{ route('properties') }}" method="GET">
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Find Anything</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['title' => null, 'page' => null]) }}" style="color: #333;"><i class="fas fa-times fa-lg"></i></a>
                                </div>
                                <input type="text" name="title" class="form-control" placeholder="Search Titles ..." value="{{ request('title') }}"/>
                            </div>
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Location</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['location_id' => null, 'page' => null]) }}" style="color: #333;"><i class="fas fa-times fa-lg"></i></a>
                                </div>
                                <select name="location_id" class="form-control select2" style="width: 100% !important">
                                    <option selected disabled>--- Select ---</option>
                                    @foreach ($locations as $location)
                                        <option @selected(request('location_id') == $location->id) value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Type</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['type_id' => null, 'page' => null]) }}" style="color: #333;"><i class="fas fa-times fa-lg"></i></a>
                                </div>
                                <select name="type_id" class="form-control select2" style="width: 100% !important">
                                    <option selected disabled>--- Select ---</option>
                                    @foreach ($propertyTypes as $type)
                                        <option @selected(request('type_id') == $type->id) value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Purpose</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['purpose' => null, 'page' => null]) }}" style="color: #333;"><i class="fas fa-times fa-lg"></i></a>
                                </div>
                                <select name="purpose" class="form-control select2" style="width: 100% !important">
                                    <option disabled selected>--- Select ---</option>
                                    <option @selected(request('purpose') == 'for rent') value="for rent">For Rent</option>
                                    <option @selected(request('purpose') == 'for sale') value="for sale">For Sale</option>
                                </select>
                            </div>
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Amenities</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['amenity' => null, 'page' => null]) }}" style="color: #333;"><i class="fas fa-times fa-lg"></i></a>
                                </div>
                                <select name="amenity[]" class="form-control select2" multiple data-placeholder="-- Select --" style="width: 100% !important">
                                    @foreach ($amenities as $amenity)
                                        <option value="{{ $amenity->id }}" @selected(in_array($amenity->id, request('amenity', [])))>{{ $amenity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Bedrooms</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['bedroom' => null, 'page' => null]) }}" style="color: #333;"><i class="fas fa-times fa-lg"></i></a>
                                </div>
                                <select name="bedroom" class="form-control select2" style="width: 100% !important">
                                    <option disabled selected>--- Select ---</option>
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option @selected((string) request('bedroom') === (string) $i) value={{ $i }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Bathrooms</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['bathroom' => null, 'page' => null]) }}" style="color: #333;"><i class="fas fa-times fa-lg"></i></a>
                                </div>
                                <select name="bathroom" class="form-control select2" style="width: 100% !important">
                                    <option disabled selected>--- Select ---</option>
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option @selected((string) request('bathroom') === (string) $i) value={{ $i }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="widget">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>Is Featured?</h2>
                                    <a href="{{ request()->fullUrlWithQuery(['is_featured' => null, 'page' => null]) }}" style="color: #333;"><i class="fas fa-times fa-lg"></i></a>
                                </div>
                                <select name="is_featured" class="form-control select2" style="width: 100% !important">
                                    <option disabled selected>--- Select ---</option>
                                    <option @selected((string) request('is_featured') === '1') value="1">Yes</option>
                                    <option @selected((string) request('is_featured') === '0') value="0">No</option>
                                </select>
                            </div>
                            <div class="widget">
                                <h2>Min Price</h2>
                                <label for="minPrice">Price: <span id="minPriceValue">${{ number_format(request('min_price') ?? 5000) }}</span></label>
                                <input type="range" id="minPrice" name="min_price" min="5000" max="20000000" step="1000" value="{{ request('min_price') ?? 5000 }}" class="form-range">
                            </div>
                            <div class="widget">
                                <h2>Max Price</h2>
                                <label for="maxPrice">Price: <span id="maxPriceValue">${{ number_format(request('max_price') ?? 5000) }}</span></label>
                                <input type="range" id="maxPrice" name="max_price" min="5000" max="20000000" step="1000" value="{{ request('max_price') ?? 5000 }}" class="form-range">
                            </div>
                            <div class="filter-button">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="property">
                        <div class="container">
                            <div class="row">
                                @if ($properties->isNotEmpty())
                                    @foreach ($properties as $property)
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="item">
                                                <div class="photo">
                                                    <img class="main" src="{{ asset('property-images/' . $property->featured_photo)}}" alt="Property-image">
                                                    <div class="top">
                                                        <div class="{{ $property->purpose == 'For Sale' ? 'status-sale' : 'status-rent'}}">
                                                                {{ $property->purpose }}
                                                        </div>
                                                        @if ($property->is_featured)
                                                            <div class="featured">
                                                                Featured
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="price">${{ number_format($property->price) }}</div>
                                                    <div class="wishlist"><a href=""><i class="far fa-heart"></i></a></div>
                                                </div>
                                                <div class="text">
                                                    <h3><a href="{{ route('property.detail', $property->slug)}}">{{ $property->name }}</a></h3>
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
                                    <div class="col-12 mt_30">
                                        {{ $properties->appends(request()->query())->links() }}
                                    </div>
                                @else
                                    <h4 class="text-danger mt_200 mb_200" style="text-align: center; font-weight: bold;">No properties match your criteria.</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const minSlider = document.getElementById('minPrice');
            const maxSlider = document.getElementById('maxPrice');

            minSlider.addEventListener('input', function () {
                document.getElementById('minPriceValue').textContent = '$' + Number(this.value).toLocaleString();

                if (Number(this.value) > Number(maxSlider.value)) {
                    maxSlider.value = this.value;
                    document.getElementById('maxPriceValue').textContent = '$' + Number(this.value).toLocaleString();
                }
            });

            maxSlider.addEventListener('input', function () {
                document.getElementById('maxPriceValue').textContent = '$' + Number(this.value).toLocaleString();
            });
        });
    </script>
@endsection
