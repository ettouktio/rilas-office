<aside class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">{{ __('ui.admin.dashboard_heading') }}</a>
    <a href="{{ route('admin.categories.index') }}" class="admin-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">{{ __('ui.admin.categories') }}</a>
    <a href="{{ route('admin.products.index') }}" class="admin-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">{{ __('ui.admin.products') }}</a>
    <a href="{{ route('admin.orders.index') }}" class="admin-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">{{ __('ui.admin.orders') }}</a>
</aside>
