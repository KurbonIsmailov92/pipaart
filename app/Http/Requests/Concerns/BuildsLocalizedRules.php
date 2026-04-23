<?php

namespace App\Http\Requests\Concerns;

trait BuildsLocalizedRules
{
    /**
     * @param  list<string|int>  $rules
     * @return array<string, array<int, string|int>>
     */
    protected function localizedFieldRules(string $field, array $rules, bool $requireFallbackLocale = true): array
    {
        $resolvedRules = [
            $field => ['required', 'array'],
        ];

        foreach (config('app.supported_locales', ['ru', 'tg', 'en']) as $locale) {
            $resolvedRules[$field.'.'.$locale] = [
                $locale === config('app.fallback_locale', 'ru') && $requireFallbackLocale ? 'required' : 'nullable',
                ...$rules,
            ];
        }

        return $resolvedRules;
    }
}
