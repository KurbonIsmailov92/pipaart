@props([
    'variant' => 'success',
])

@php
    $classes = match ($variant) {
        'danger' => 'rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-700',
        default => 'rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700',
    };
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
