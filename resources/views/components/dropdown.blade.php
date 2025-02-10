<div class="relative group z-index: 1050">
<x-dropdown-button href="{{ $buttonHref }}" text="{!! $buttonText !!}"/>
<x-dropdown-menu>
    {{ $slot }}
</x-dropdown-menu>
</div>
