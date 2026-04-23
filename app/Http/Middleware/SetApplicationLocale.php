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
        $supportedLocales = config('app.supported_locales', ['ru', 'tg', 'en']);
        $defaultLocale = config('app.locale', 'ru');
        $routeLocale = $request->route('locale');

        $locale = is_string($routeLocale) && in_array($routeLocale, $supportedLocales, true)
            ? $routeLocale
            : $request->session()->get('locale', $defaultLocale);

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);
        $request->session()->put('locale', $locale);

        if (is_string($request->route('locale'))) {
            URL::defaults(['locale' => $locale]);
        }

        return $next($request);
    }
}
