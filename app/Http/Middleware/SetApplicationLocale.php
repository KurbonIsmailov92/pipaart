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
        $locale = $this->resolveLocale($request, $routeLocale, $supportedLocales, $defaultLocale);

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        if ($request->route()?->hasParameter('locale')) {
            URL::defaults(['locale' => $locale]);
        }

        if ($request->hasSession()) {
            $request->session()->put('locale', $locale);
        }

        return $next($request);
    }

    /**
     * @param  list<string>  $supportedLocales
     */
    protected function resolveLocale(
        Request $request,
        mixed $routeLocale,
        array $supportedLocales,
        string $defaultLocale,
    ): string {
        if (is_string($routeLocale) && in_array($routeLocale, $supportedLocales, true)) {
            return $routeLocale;
        }

        if ($request->hasSession()) {
            $sessionLocale = $request->session()->get('locale');

            if (is_string($sessionLocale) && in_array($sessionLocale, $supportedLocales, true)) {
                return $sessionLocale;
            }
        }

        return in_array($defaultLocale, $supportedLocales, true) ? $defaultLocale : 'ru';
    }
}
