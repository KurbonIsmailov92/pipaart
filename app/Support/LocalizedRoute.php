<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

class LocalizedRoute
{
    /**
     * @return list<string>
     */
    public static function supportedLocales(): array
    {
        /** @var list<string> $locales */
        $locales = config('app.supported_locales', ['ru', 'tg', 'en']);

        return $locales;
    }

    public static function currentLocale(): string
    {
        return app()->getLocale();
    }

    public static function switchUrl(string $locale): string
    {
        $route = request()->route();
        $routeName = Route::currentRouteName();

        if ($routeName === null || $route === null) {
            return url($locale);
        }

        $parameters = $route->parameters();
        unset($parameters['locale']);

        if (! self::routeUsesLocale($routeName)) {
            return url()->current();
        }

        return route($routeName, ['locale' => $locale, ...$parameters]);
    }

    /**
     * @return array<string, string>
     */
    public static function alternateUrls(): array
    {
        $urls = [];

        foreach (self::supportedLocales() as $locale) {
            $urls[$locale] = self::switchUrl($locale);
        }

        return $urls;
    }

    public static function routeUsesLocale(?string $routeName = null): bool
    {
        $routeName ??= Route::currentRouteName();

        if ($routeName === null) {
            return false;
        }

        $route = Route::getRoutes()->getByName($routeName);

        return $route !== null && str_contains($route->uri(), '{locale}');
    }
}
