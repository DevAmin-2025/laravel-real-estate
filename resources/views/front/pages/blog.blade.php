@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('uploads/banner.jpg') }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Blog</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="blog">
        <div class="container">
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
                <div class="col-md-12">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
