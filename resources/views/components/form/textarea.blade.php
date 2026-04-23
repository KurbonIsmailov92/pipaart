@props(['label', 'name'])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => 'min-h-36 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200',
        'rows' => 8,
    ];
@endphp

<x-form.field :label="$label" :name="$name">
    <textarea {{ $attributes->merge($defaults) }}>{{ $slot ?? old($name) }}</textarea>
</x-form.field>
