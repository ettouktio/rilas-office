<footer class="site-footer">
    <div class="container footer-inner">
        <div>
            <strong>{{ config('app.name', 'RILAS Office') }}</strong>
            <p class="muted">{{ __('ui.footer.tagline') }}</p>
        </div>

        <div class="footer-links">
            <a href="{{ route('shop') }}">{{ __('ui.nav.shop') }}</a>
            <a href="{{ route('cart.index') }}">{{ __('ui.nav.cart') }}</a>
            <a href="{{ route('checkout.create') }}">{{ __('ui.nav.checkout') }}</a>
        </div>
    </div>
</footer>
