<?php

namespace App\Services;

use App\Models\HomeHero;
use Illuminate\Support\Facades\Schema;
use Throwable;

class HomeHeroService
{
    /**
     * @param  array<string, string>  $defaults
     * @return array<string, string>
     */
    public function forLocale(string $locale, array $defaults): array
    {
        try {
            if (! Schema::hasTable('home_heroes')) {
                return $defaults;
            }

            $hero = HomeHero::query()
                ->where('locale', $locale)
                ->where('is_active', true)
                ->first()
                ?? HomeHero::query()
                    ->where('locale', config('app.locale', 'ru'))
                    ->where('is_active', true)
                    ->first()
                ?? HomeHero::query()
                    ->where('is_active', true)
                    ->orderByRaw("case when locale = 'ru' then 0 else 1 end")
                    ->first();

            if ($hero === null) {
                return $defaults;
            }

            $fallbackUrl = $defaults['cta_url'] ?? '/'.$locale.'/courses';

            return array_replace($defaults, [
                'title' => $hero->title,
                'subtitle' => (string) $hero->subtitle,
                'cta_text' => $hero->cta_text ?: ($defaults['cta_text'] ?? ''),
                'cta_url' => $hero->localizedCtaUrl($locale, $fallbackUrl),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return $defaults;
        }
    }
}
