@php
    $user = Auth::guard('web')->check();
@endphp

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item active">
            <a href="{{ $user ? route('user.dashboard') : route('agent.dashboard') }}">Dashboard</a>
        </li>
        @unless ($user)
            <li class="list-group-item">
                <a href="user-payment.html">Make Payment</a>
            </li>
            <li class="list-group-item">
                <a href="user-orders.html">Orders</a>
            </li>
            <li class="list-group-item">
                <a href="user-property-add.html">Add Property</a>
            </li>
            <li class="list-group-item">
                <a href="user-properties.html">All Properties</a>
            </li>
        @endunless
        @if ($user)
            <li class="list-group-item">
                <a href="user-wishlist.html">Wishlist</a>
            </li>
        @endif
        <li class="list-group-item">
            <a href="{{ $user ? route('user.edit.profile') : route('agent.edit.profile') }}">Edit Profile</a>
        </li>
        <li class="list-group-item logout">
            <form action="{{ $user ? route('user.logout') : route('agent.logout') }}" method="POST" class="d-block m-0 p-0">
                @csrf
                <button type="submit" class="nav-link w-100 text-start text-danger border-0 bg-transparent p-0 logout-btn"
                    style="margin: 8px 0 8px 15px; font-weight: bold;">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>
