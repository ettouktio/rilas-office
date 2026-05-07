<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('ui.meta.description') }}">
    <title>@yield('title', config('app.name', 'RILAS Office'))</title>
    <script>
        (() => {
            const storedTheme = localStorage.getItem('rilas-theme');
            const preferredTheme = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
            document.documentElement.dataset.theme = storedTheme || preferredTheme;
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
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

            if (toggle && nav) {
                toggle.addEventListener('click', () => {
                    nav.classList.toggle('open');
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
