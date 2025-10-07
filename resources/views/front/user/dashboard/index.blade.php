@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>User Dashboard</h2>
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
                    <h3>Hello {{ $user->name }}</h3>
                    <p>See all the statistics at a glance:</p>

                    <div class="row box-items">
                        <div class="col-md-4">
                            <div class="box1">
                                <h4>{{ $messageCount }}</h4>
                                <p>Messages</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-5">Properties You recently liked</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($wishlistItems as $wishlistItem)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('property-images/' . $wishlistItem->property->featured_photo)}}" class="w-150" alt="Property-image">
                                        </td>
                                        <td>
                                            <a href="{{ route('property.detail', $wishlistItem->property->slug) }}" style="color: inherit;">{{ $wishlistItem->property->name }}</a>
                                        </td>
                                        <td>${{ number_format($wishlistItem->property->price) }}</td>
                                        <td>
                                            <form action="{{ route('user.remove.from.wishlist', $wishlistItem) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
