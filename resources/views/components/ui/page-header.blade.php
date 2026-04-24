@props([
    'title',
    'description' => null,
    'eyebrow' => null,
])

<div class="surface-card relative mb-8 overflow-hidden px-6 py-8 sm:px-8 sm:py-10">
    <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-[radial-gradient(circle_at_center,_rgba(215,187,119,0.24),_transparent_60%)] lg:block"></div>
    <div class="max-w-3xl">
        <p class="ui-kicker">{{ $eyebrow ?: ($siteSettings['site_name'] ?? 'PIPAA') }}</p>
        <h1 class="ui-title">{{ $title }}</h1>
        @if($description)
            <p class="ui-copy max-w-2xl">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="relative mt-6 flex flex-wrap gap-3 sm:mt-8">
            {{ $actions }}
        </div>
    @endisset
</div>
