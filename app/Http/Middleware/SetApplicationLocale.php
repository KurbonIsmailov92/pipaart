<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetApplicationLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var list<string> $supportedLocales */
        $supportedLocales = config('app.supported_locales', ['ru', 'tg', 'en']);
        $defaultLocale = config('app.locale', 'ru');
        $routeLocale = $request->route('locale');
        $sessionLocale = $request->hasSession()
            ? $request->session()->get('locale')
            : null;

        $locale = is_string($routeLocale) && in_array($routeLocale, $supportedLocales, true)
            ? $routeLocale
            : $sessionLocale;

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        if ($request->hasSession()) {
            $request->session()->put('locale', $locale);
        }

        return $next($request);
    }
}
