@props([
    'href',
    'variant' => 'primary',
])

@php
    $classes = match ($variant) {
        'secondary' => 'ui-button ui-button-secondary',
        'ghost' => 'ui-button ui-button-ghost',
        default => 'ui-button ui-button-primary',
    };
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
