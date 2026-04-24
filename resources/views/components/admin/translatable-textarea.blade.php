@props([
    'field',
    'label',
    'model' => null,
    'rows' => 6,
    'required' => true,
])

@php
    $locales = config('app.supported_locales', ['ru', 'tg', 'en']);
    $fallbackLocale = config('app.fallback_locale', 'ru');
@endphp

<div class="grid gap-4">
    <p class="text-sm font-medium text-slate-700">{{ $label }}</p>

    <div class="grid gap-4 lg:grid-cols-3">
        @foreach($locales as $locale)
            @php
                $value = old($field.'.'.$locale);

                if ($value === null && $model !== null && method_exists($model, 'getTranslation')) {
                    $value = $model->getTranslation($field, $locale, false);
                }
            @endphp

            <div>
                <label for="{{ $field }}_{{ $locale }}" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                    {{ strtoupper($locale) }}
                </label>
                <textarea
                    id="{{ $field }}_{{ $locale }}"
                    name="{{ $field }}[{{ $locale }}]"
                    rows="{{ $rows }}"
                    @if($required && $locale === $fallbackLocale) required @endif
                    class="w-full rounded-xl border border-slate-300 px-4 py-3"
                >{{ $value }}</textarea>
                @error($field.'.'.$locale)
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endforeach
    </div>

    @error($field)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
