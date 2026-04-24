@props([
    'variant' => 'success',
])

@php
    $classes = match ($variant) {
        'danger' => 'rounded-[1.6rem] border border-rose-200 bg-rose-50/90 px-4 py-3 text-rose-700',
        default => 'rounded-[1.6rem] border border-emerald-200 bg-emerald-50/90 px-4 py-3 text-emerald-700',
    };
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
