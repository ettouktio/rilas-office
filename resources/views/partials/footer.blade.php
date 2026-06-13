<footer class="site-footer">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-brand-text">
                <img src="/assets/rilas-office-logo-dark.png" alt="{{ config('app.name', 'RILAS Office') }}" class="footer-logo theme-logo theme-logo-dark">
                <img src="/assets/rilas-office-logo-light.png" alt="{{ config('app.name', 'RILAS Office') }}" class="footer-logo theme-logo theme-logo-light">
                <p class="muted">{{ __('ui.footer.tagline') }}</p>
                <div class="footer-developer">
                    <span class="footer-developer-label">{{ __('ui.footer.developed_by') }}</span>
                    <span class="footer-developer-name">Oussama Ettoukti</span>
                </div>
            </div>

            <div>
                <div class="footer-section-title">{{ __('ui.nav.shop') }}</div>
                <div class="footer-links">
                    <a href="{{ route('shop') }}">{{ __('ui.common.browse_products') }}</a>
                    <a href="{{ route('cart.index') }}">{{ __('ui.nav.cart') }}</a>
                    <a href="{{ route('checkout.create') }}">{{ __('ui.nav.checkout') }}</a>
                </div>
            </div>

            <div>
                <div class="footer-section-title">{{ __('ui.nav.account') }}</div>
                <div class="footer-links">
                    @auth
                        <a href="{{ route('logout') }}">{{ __('ui.nav.logout') }}</a>
                    @else
                        <a href="{{ route('login') }}">{{ __('ui.nav.login') }}</a>
                        <a href="{{ route('register') }}">{{ __('ui.nav.register') }}</a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <span class="footer-copy">&copy; {{ date('Y') }} {{ config('app.name', 'RILAS Office') }}. {{ __('ui.footer.rights') }}</span>
        </div>
    </div>
</footer>
