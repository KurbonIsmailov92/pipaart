@props(['label', 'name'])

<div>
    @if ($label)
        <x-form.label :$name :$label />
    @endif

    <div class="mt-1">
        {{ $slot }}
    </div>
</div>

