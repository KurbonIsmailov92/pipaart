<?php

namespace App\Http\Requests\Concerns;

use App\Rules\HasFilledTranslation;

trait BuildsLocalizedRules
{
    /**
     * @param  list<string|int>  $rules
     * @return array<string, array<int, mixed>>
     */
    protected function localizedFieldRules(
        string $field,
        array $rules,
        bool $required = true,
        bool $requireAtLeastOneTranslation = false
    ): array {
        $resolvedRules = [
            $field => [$required ? 'required' : 'nullable', 'array'],
        ];

        if ($requireAtLeastOneTranslation) {
            $resolvedRules[$field][] = new HasFilledTranslation;
        }

        foreach (config('app.supported_locales', ['ru', 'tg', 'en']) as $locale) {
            $resolvedRules[$field.'.'.$locale] = [
                $required && ! $requireAtLeastOneTranslation && $locale === config('app.fallback_locale', 'ru')
                    ? 'required'
                    : 'nullable',
                ...$rules,
            ];
        }

        return $resolvedRules;
    }
}
