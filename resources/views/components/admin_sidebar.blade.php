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
        </ul>
    </aside>
</div>
