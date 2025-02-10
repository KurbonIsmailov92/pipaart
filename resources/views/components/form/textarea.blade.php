@props(['label', 'name'])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => 'rounded-xl bg-white/40 border px-5 py-3 w-full h-32 resize-y border-white
                    focus:border-blue-900 focus:ring focus:ring-blue-300 focus:outline-none focus:!bg-white/80',
        'rows' => 10,
    ];
@endphp

<x-form.field :label="$label" :name="$name">
    <textarea {{ $attributes->merge($defaults) }}>{{ $slot ?? old($name) }}</textarea>
</x-form.field>




