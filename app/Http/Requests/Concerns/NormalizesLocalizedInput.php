<?php

namespace App\Http\Requests\Concerns;

trait NormalizesLocalizedInput
{
    /**
     * @param  list<string>  $fields
     */
    protected function normalizeLocalizedFields(array $fields): void
    {
        $payload = [];

        foreach ($fields as $field) {
            $value = $this->input($field);

            if (is_array($value)) {
                if (isset($value['tj']) && ! isset($value['tg'])) {
                    $value['tg'] = $value['tj'];
                }

                $payload[$field] = $value;
            } elseif (is_string($value)) {
                $payload[$field] = [
                    $this->fallbackLocale() => trim($value),
                ];
            }
        }

        if ($payload !== []) {
            $this->merge($payload);
        }
    }

    protected function fallbackLocale(): string
    {
        $locale = (string) ($this->input('locale') ?: app()->getLocale());
        $supportedLocales = config('app.supported_locales', ['ru', 'tg', 'en']);

        return in_array($locale, $supportedLocales, true)
            ? $locale
            : (string) config('app.fallback_locale', 'ru');
    }
}
