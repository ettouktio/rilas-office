<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('ui.meta.description') }}">
    <title>@yield('title', config('app.name', 'RILAS Office'))</title>
    <link rel="icon" type="image/png" href="/assets/rilas-office-logo-dark.png">
    <link rel="stylesheet" href="/assets/app.css?v={{ filemtime(public_path('assets/app.css')) }}">
    <script>
        (() => {
            const storedTheme = localStorage.getItem('rilas-theme');
            const preferredTheme = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
            document.documentElement.dataset.theme = storedTheme || preferredTheme;
        })();
    </script>
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</head>
<body>
    <div class="site-shell">
        @include('partials.header')

        <main class="page-shell">
            <div class="container">
                @include('partials.alerts')
            </div>

            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('mobile-nav-toggle');
            const nav = document.getElementById('primary-nav');
            const navScrim = document.getElementById('nav-scrim');
            const themeToggle = document.getElementById('theme-toggle');
            const themeLabel = document.getElementById('theme-toggle-label');
            const root = document.documentElement;

            const applyThemeLabel = (theme) => {
                if (!themeToggle || !themeLabel) {
                    return;
                }

                const nextTheme = theme === 'dark' ? 'light' : 'dark';
                themeLabel.textContent = nextTheme === 'light'
                    ? themeToggle.dataset.lightLabel
                    : themeToggle.dataset.darkLabel;
            };

            const setMobileNav = (isOpen) => {
                if (!toggle || !nav) {
                    return;
                }

                nav.classList.toggle('open', isOpen);
                navScrim?.classList.toggle('open', isOpen);
                document.body.classList.toggle('nav-open', isOpen);
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            };

            if (toggle && nav) {
                toggle.addEventListener('click', () => setMobileNav(!nav.classList.contains('open')));
                navScrim?.addEventListener('click', () => setMobileNav(false));
                nav.querySelectorAll('a').forEach((link) => {
                    link.addEventListener('click', () => setMobileNav(false));
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        setMobileNav(false);
                    }
                });
            }

            applyThemeLabel(root.dataset.theme || 'dark');

            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const currentTheme = root.dataset.theme === 'light' ? 'light' : 'dark';
                    const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';

                    root.dataset.theme = nextTheme;
                    localStorage.setItem('rilas-theme', nextTheme);
                    applyThemeLabel(nextTheme);
                });
            }
        });
    </script>
</body>
</html>
