<header class="site-header">
    <div class="container header-inner">
        <a href="{{ route('home') }}" class="brand">{{ config('app.name', 'RILAS Office') }}</a>

        <button type="button" class="mobile-nav-toggle" id="mobile-nav-toggle" aria-controls="primary-nav" aria-expanded="false">{{ __('ui.nav.menu') }}</button>

        <nav class="primary-nav" id="primary-nav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('ui.nav.home') }}</a>
            <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}">{{ __('ui.nav.shop') }}</a>
            <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                {{ __('ui.nav.cart') }} <span class="count-pill">{{ $cartItemCount ?? 0 }}</span>
            </a>
            <a href="{{ route('checkout.create') }}" class="{{ request()->routeIs('checkout.*') ? 'active' : '' }}">{{ __('ui.nav.checkout') }}</a>

            <details class="nav-categories">
                <summary>{{ __('ui.nav.categories') }}</summary>
                <div class="nav-categories-panel">
                    @forelse ($navigationCategories as $category)
                        <div class="nav-category-group">
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" class="nav-category-root">{{ $category->localized_name }}</a>
                            @foreach ($category->children as $child)
                                <a href="{{ route('shop', ['category' => $child->slug]) }}" class="nav-category-child">{{ $child->localized_name }}</a>
                            @endforeach
                        </div>
                    @empty
                        <p class="muted">{{ __('ui.nav.seed_notice') }}</p>
                    @endforelse
                </div>
            </details>
        </nav>

        <button type="button" class="nav-scrim" id="nav-scrim" aria-label="{{ __('ui.nav.close_menu') }}"></button>

        <div class="header-actions">
            <div class="preference-group" aria-label="{{ __('ui.preferences.language') }}">
                @foreach ($supportedLocales as $localeCode => $localeMeta)
                    <a href="{{ route('locale.update', $localeCode) }}" class="segment {{ app()->getLocale() === $localeCode ? 'active' : '' }}">
                        {{ $localeMeta['label'] }}
                    </a>
                @endforeach
            </div>

            <button
                type="button"
                class="btn btn-ghost theme-toggle"
                id="theme-toggle"
                data-light-label="{{ __('ui.preferences.light') }}"
                data-dark-label="{{ __('ui.preferences.dark') }}"
                aria-label="{{ __('ui.preferences.theme') }}"
            >
                <span class="theme-toggle-swatch" aria-hidden="true"></span>
                <span id="theme-toggle-label"></span>
            </button>

            @auth
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">{{ __('ui.nav.admin') }}</a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost">{{ __('ui.nav.logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">{{ __('ui.nav.login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary">{{ __('ui.nav.register') }}</a>
            @endauth
        </div>
    </div>
</header>
