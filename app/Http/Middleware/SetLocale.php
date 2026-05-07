<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = array_keys(config('rilas.supported_locales', []));
        $configuredLocale = (string) config('app.locale', 'fr');
        $defaultLocale = in_array($configuredLocale, $supportedLocales, true) ? $configuredLocale : 'fr';
        $locale = (string) $request->session()->get('locale', $defaultLocale);

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
