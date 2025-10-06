<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="item">
                    <h2 class="heading">Important Links</h2>
                    <ul class="useful-links">
                        <li><a href="{{ route('pricing') }}">Pricing</a></li>
                        <li><a href="{{ route('properties') }}">Properties</a></li>
                        <li><a href="{{ route('agents') }}">Agents</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                @php
                    $popularLocations = App\Models\Location::withCount([
                        'properties' => function ($query) {
                            $query->where('status', 1);
                        }
                    ])->orderByDesc('properties_count')->take(4)->get();
                @endphp
                <div class="item">
                    <h2 class="heading">Popular Locations</h2>
                    <ul class="useful-links">
                        @foreach ($popularLocations as $location)
                            <li><a href="{{ route('location.detail', $location->slug) }}">{{ $location->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="item">
                    <h2 class="heading">Contact</h2>
                    <div class="list-item">
                        <div class="left">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="right">
                            {{ $footer->address }}
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="left">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="right">{{ $footer->phone }}</div>
                    </div>
                    <div class="list-item">
                        <div class="left">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="right">{{ $footer->email }}</div>
                    </div>
                    <ul class="social">
                        @if ($footer->facebook)
                            <li>
                                <a href="{{ $footer->facebook }}"><i class="fab fa-facebook-f"></i></a>
                            </li>
                        @endif
                        @if ($footer->twitter)
                            <li>
                                <a href="{{ $footer->twitter }}"><i class="fab fa-twitter"></i></a>
                            </li>
                        @endif
                        @if ($footer->linkedin)
                            <li>
                                <a href="{{ $footer->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                        @endif
                        @if ($footer->instagram)
                            <li>
                                <a href="{{ $footer->instagram }}"><i class="fab fa-instagram"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="item">
                    <h2 class="heading">Newsletter</h2>
                    <p>
                        To get the latest news from our website, please
                        subscribe us here:
                    </p>
                    <form action="{{ route('subscribe') }}" method="POST" class="form_subscribe_ajax">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Your Email Address">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Subscribe Now">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="copyright">
                    {{ $footer->copyright }}
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="right">
                    <ul>
                        <li><a href="{{ route('terms') }}">Terms of Use</a></li>
                        <li>
                            <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="scroll-top">
    <i class="fas fa-angle-up"></i>
</div>
<div id="loader"></div>

<script src="{{ asset('dist-front/js/custom.js') }}"></script>
<script src="{{ asset('dist-admin/js/iziToast.min.js') }}"></script>

@if (session('success'))
    <script>
        iziToast.success({
            message: '{{ session('success') }}',
            position: 'topRight',
            timeout: 3000,
            progressBarColor: '#2ecc71',
            transitionIn: 'bounceInDown',
            transitionOut: 'fadeOutUp'
        });
    </script>
@endif
@if (session('error'))
    <script>
        iziToast.error({
            message: '{{ session('error') }}',
            position: 'topRight',
            timeout: 3000,
            progressBarColor: '#FF0000',
            transitionIn: 'bounceInDown',
            transitionOut: 'fadeOutUp'
        });
    </script>
@endif

<script>
    (function($) {
        $(".form_subscribe_ajax").on('submit', function(e) {
            e.preventDefault();
            $('#loader').show();

            var form = this;

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,

                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },

                success: function(data) {
                    $('#loader').hide();

                    if (data.code == 0) {
                        $.each(data.error_message, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val[0]);
                        });
                    } else if (data.code == 1) {
                        $(form)[0].reset();

                        iziToast.success({
                            message: data.success_message,
                            position: 'topRight',
                            timeout: 5000,
                            progressBarColor: '#00FF00',
                        });
                    }
                }
            });
        });
    })(jQuery);
</script>
