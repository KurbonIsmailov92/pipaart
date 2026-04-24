@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'ui-section']) }}>
    @if($title || $description || isset($actions))
        <div class="ui-section-heading">
            <div class="max-w-3xl">
                @if($eyebrow)
                    <p class="ui-kicker">{{ $eyebrow }}</p>
                @endif
                @if($title)
                    <h2 class="ui-title">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="ui-copy">{{ $description }}</p>
                @endif
            </div>

            @isset($actions)
                <div class="flex flex-wrap gap-3">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    {{ $slot }}
</section>
