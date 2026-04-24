<button
    type="submit"
    {{ $attributes->merge(['class' => 'ui-button ui-button-primary']) }}
>
    {{ $slot }}
</button>
