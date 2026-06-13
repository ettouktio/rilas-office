<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="{{ __('ui.meta.description') }}">
    <meta name="theme-color" content="#08090a" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#f5f6f8" media="(prefers-color-scheme: light)">
    <title>@yield('title', config('app.name', 'RILAS Office'))</title>
    <link rel="icon" type="image/png" href="/assets/rilas-office-logo-dark.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/app.css?v={{ filemtime(public_path('assets/app.css')) }}">
    <script>
        (() => {
            const storedTheme = localStorage.getItem('rilas-theme');
            const preferredTheme = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
            document.documentElement.dataset.theme = storedTheme || preferredTheme;
        })();
    </script>
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
                if (!themeToggle || !themeLabel) return;
                const nextTheme = theme === 'dark' ? 'light' : 'dark';
                themeLabel.textContent = nextTheme === 'light'
                    ? themeToggle.dataset.lightLabel
                    : themeToggle.dataset.darkLabel;
            };

            const setMobileNav = (isOpen) => {
                if (!toggle || !nav) return;
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
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') setMobileNav(false);
                });
            }

            applyThemeLabel(root.dataset.theme || 'dark');

            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const current = root.dataset.theme === 'light' ? 'light' : 'dark';
                    const next = current === 'dark' ? 'light' : 'dark';
                    root.dataset.theme = next;
                    localStorage.setItem('rilas-theme', next);
                    applyThemeLabel(next);
                });
            }
        });
    </script>
</body>
</html>
