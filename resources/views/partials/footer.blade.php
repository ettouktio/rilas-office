<footer class="site-footer">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand-text">
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

        <div class="footer-bottom">
            <span class="footer-copy">&copy; {{ date('Y') }} {{ config('app.name', 'RILAS Office') }}. {{ __('ui.footer.rights') }}</span>
        </div>
    </div>
</footer>
