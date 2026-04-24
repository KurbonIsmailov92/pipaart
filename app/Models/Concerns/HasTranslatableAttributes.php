<?php

namespace App\Models\Concerns;

trait HasTranslatableAttributes
{
    /**
     * @return list<string>
     */
    public function getTranslatableAttributes(): array
    {
        /** @var list<string> $attributes */
        $attributes = property_exists($this, 'translatable')
            ? $this->translatable
            : [];

        return $attributes;
    }

    public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->getTranslatableAttributes(), true);
    }

    public function getTranslation(string $key, ?string $locale = null, bool $useFallback = true): string
    {
        $locale ??= app()->getLocale();
        $translations = $this->getTranslations($key);

        if (($translations[$locale] ?? null) !== null && $translations[$locale] !== '') {
            return (string) $translations[$locale];
        }

        $fallbackLocale = config('app.fallback_locale', 'ru');

        if (
            $useFallback
            && ($translations[$fallbackLocale] ?? null) !== null
            && $translations[$fallbackLocale] !== ''
        ) {
            return (string) $translations[$fallbackLocale];
        }

        foreach (config('app.supported_locales', ['ru', 'tg', 'en']) as $supportedLocale) {
            if (($translations[$supportedLocale] ?? null) !== null && $translations[$supportedLocale] !== '') {
                return (string) $translations[$supportedLocale];
            }
        }

        return '';
    }

    /**
     * @return array<string, string>
     */
    public function getTranslations(string $key): array
    {
        if (! $this->isTranslatableAttribute($key)) {
            return [];
        }

        $rawValue = $this->getRawOriginal($key);

        if (blank($rawValue)) {
            return [];
        }

        if (is_array($rawValue)) {
            return $this->normalizeTranslations($rawValue);
        }

        $decoded = json_decode((string) $rawValue, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $this->normalizeTranslations($decoded);
        }

        return $this->normalizeTranslations([
            config('app.fallback_locale', 'ru') => (string) $rawValue,
        ]);
    }

    /**
     * @param  array<string, mixed>  $translations
     */
    public function setTranslations(string $key, array $translations): static
    {
        $this->setAttribute($key, $translations);

        return $this;
    }

    public function getAttributeValue($key): mixed
    {
        $value = parent::getAttributeValue($key);

        if (! is_string($key) || ! $this->isTranslatableAttribute($key)) {
            return $value;
        }

        if (is_array($value)) {
            return $this->resolveTranslationValue($value);
        }

        return $value;
    }

    public function setAttribute($key, $value): mixed
    {
        if (is_string($key) && $this->isTranslatableAttribute($key) && is_array($value)) {
            $value = $this->normalizeTranslations($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * @param  array<string, mixed>  $translations
     */
    protected function normalizeTranslations(array $translations): array
    {
        $normalized = [];

        foreach (config('app.supported_locales', ['ru', 'tg', 'en']) as $locale) {
            $value = trim((string) ($translations[$locale] ?? ''));

            if ($value !== '') {
                $normalized[$locale] = $value;
            }
        }

        return $normalized;
    }

    /**
     * @param  array<string, mixed>  $translations
     */
    protected function resolveTranslationValue(array $translations): string
    {
        $locale = app()->getLocale();

        if (($translations[$locale] ?? null) !== null && $translations[$locale] !== '') {
            return (string) $translations[$locale];
        }

        $fallbackLocale = config('app.fallback_locale', 'ru');

        if (($translations[$fallbackLocale] ?? null) !== null && $translations[$fallbackLocale] !== '') {
            return (string) $translations[$fallbackLocale];
        }

        foreach (config('app.supported_locales', ['ru', 'tg', 'en']) as $supportedLocale) {
            if (($translations[$supportedLocale] ?? null) !== null && $translations[$supportedLocale] !== '') {
                return (string) $translations[$supportedLocale];
            }
        }

        return '';
    }
}
