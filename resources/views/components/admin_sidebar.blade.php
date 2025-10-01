<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.panel') }}">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.panel') }}"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item {{ request()->routeIs('admin.panel') ? 'active' : ''}}"><a class="nav-link" href="{{ route('admin.panel') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
            <li class="nav-item {{ request()->routeIs('admin.plans.*') ? 'active' : ''}}"><a class="nav-link" href="{{ route('admin.plans.index') }}"><i class="fas fa-chart-pie"></i> <span>Plans</span></a></li>

            <li class="nav-item dropdown {{ request()->routeIs('admin.locations.*', 'admin.property.types.*', 'admin.amenities.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown "><i class="fas fa-folder"></i><span>Property Section</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.locations.*') ? 'active' : ''}}"><a class="nav-link" href="{{ route('admin.locations.index') }}"><i class="fas fa-angle-right"></i>Locations</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.property.types.*') ? 'active' : ''}}"><a class="nav-link" href="{{ route('admin.property.types.index') }}"><i class="fas fa-angle-right"></i>Types</a></li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.amenities.*') ? 'active' : ''}}"><a class="nav-link" href="{{ route('admin.amenities.index') }}"><i class="fas fa-angle-right"></i>Amenities</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
