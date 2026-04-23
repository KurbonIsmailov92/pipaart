@props(['label', 'name'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200',
        'value' => old($name),
    ];
@endphp

<x-form.field :$label :$name>
    <input {{ $attributes->merge($defaults) }}>
</x-form.field>
