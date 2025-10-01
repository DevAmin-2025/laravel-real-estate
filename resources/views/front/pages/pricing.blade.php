@extends('front.layouts.master')
@section('content')
        <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Pricing</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content pricing" style="margin: 40px 0;">
        <div class="container">
            <div class="row pricing">
                @foreach ($plans as $plan)
                    <div class="col-lg-4 mb_30">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h2 class="card-title">{{ $plan->name }}</h2>
                                <h3 class="card-price">${{ number_format($plan->price) }}</h3>
                                <h4 class="card-day">({{  $plan->allowed_days == '-1' ? 'Unlimited' : $plan->allowed_days . ' Days' }})</h4>
                                <hr />
                                <ul class="fa-ul">
                                    <li>
                                        <span class="fa-li"><i class="{{ displayIcon($plan->allowed_properties, 'fas fa-check', 'fas fa-times') }}"></i></span>{{ formatLimit($plan->allowed_properties, 'Property') }}
                                    </li>
                                    <li>
                                        <span class="fa-li"><i class="{{ displayIcon($plan->allowed_featured_properties, 'fas fa-check', 'fas fa-times') }}"></i></span>{{ formatLimit($plan->allowed_featured_properties, 'Featured Property') }}
                                    </li>
                                    <li>
                                        <span class="fa-li"><i class="{{ displayIcon($plan->allowed_photos, 'fas fa-check', 'fas fa-times') }}"></i></span>{{ formatLimit($plan->allowed_photos, 'Photo', 'per Property') }}
                                    </li>
                                    <li>
                                        <span class="fa-li"><i class="{{ displayIcon($plan->allowed_videos, 'fas fa-check', 'fas fa-times') }}"></i></span>{{ formatLimit($plan->allowed_videos, 'Video', 'per Property') }}
                                    </li>
                                </ul>
                                <div class="buy">
                                    <form action="{{ route('agent.payment.send', $plan) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary"
                                        style="width: 100%; background-color: #d92228; border: none; font-weight: 500;">
                                            Buy Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($plans->isEmpty())
                    <div class="col-12 text-center my-5">
                        <h4 class="text-muted">No plans are currently available.</h4>
                        <p>Please check back later or contact support for more information.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
