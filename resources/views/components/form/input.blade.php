@props(['label', 'name'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => 'rounded-xl bg-white/40 border px-5 py-3 w-full border-white
                    focus:border-blue-900 focus:ring focus:ring-blue-300 focus:outline-none focus:!bg-white/80',
        'value' => old($name)
    ];
@endphp

<x-form.field :$label :$name>
    <input {{ $attributes($defaults) }}>
</x-form.field>


