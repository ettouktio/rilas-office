<footer class="site-footer">
    <div class="container footer-inner">
        <div>
            <img src="/assets/rilas-office-logo-dark.png" alt="{{ config('app.name', 'RILAS Office') }}" class="footer-logo theme-logo theme-logo-dark">
            <img src="/assets/rilas-office-logo-light.png" alt="{{ config('app.name', 'RILAS Office') }}" class="footer-logo theme-logo theme-logo-light">
            <p class="muted">{{ __('ui.footer.tagline') }}</p>
        </div>

        <div class="footer-links">
            <a href="{{ route('shop') }}">{{ __('ui.nav.shop') }}</a>
            <a href="{{ route('cart.index') }}">{{ __('ui.nav.cart') }}</a>
            <a href="{{ route('checkout.create') }}">{{ __('ui.nav.checkout') }}</a>
        </div>
    </div>
</footer>
