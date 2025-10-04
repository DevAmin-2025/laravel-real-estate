@php
    $user = Auth::guard('web')->check();
@endphp

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item {{ request()->routeIs('user.dashboard', 'agent.dashboard') ? 'active' : ''}}">
            <a href="{{ $user ? route('user.dashboard') : route('agent.dashboard') }}">Dashboard</a>
        </li>
        @unless ($user)
            <li class="list-group-item {{ request()->routeIs('agent.plan') ? 'active' : ''}}">
                <a href="{{ route('agent.plan') }}">Active Plan</a>
            </li>
            <li class="list-group-item {{ request()->routeIs('agent.orders', 'agent.invoice') ? 'active' : ''}}">
                <a href="{{ route('agent.orders') }}">Orders</a>
            </li>
            <li class="list-group-item {{ request()->routeIs(
            'agent.properties.index',
            'agent.properties.show',
            'agent.properties.edit',
            'agent.photo.gallery',
            'agent.video.gallery'
            ) ? 'active' : ''}}">
                <a href="{{ route('agent.properties.index') }}">All Properties</a>
            </li>
            <li class="list-group-item {{ request()->routeIs('agent.properties.create') ? 'active' : ''}}">
                <a href="{{ route('agent.properties.create') }}">Add Property</a>
            </li>
        @endunless
        <li class="list-group-item">
            <a href="">Messages</a>
        </li>
        @if ($user)
            <li class="list-group-item {{ request()->routeIs('user.wishlist') ? 'active' : ''}}">
                <a href="{{ route('user.wishlist') }}">Wishlist</a>
            </li>
        @endif
        <li class="list-group-item {{ request()->routeIs('user.edit.profile', 'agent.edit.profile') ? 'active' : ''}}">
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
