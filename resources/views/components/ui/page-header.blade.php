@props([
    'title',
    'description' => null,
])

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="max-w-3xl">
        <p class="text-xs uppercase tracking-[0.35em] text-blue-700">PIPAA</p>
        <h1 class="mt-2 text-3xl font-semibold text-slate-950 sm:text-4xl">{{ $title }}</h1>
        @if($description)
            <p class="mt-3 text-base text-slate-600">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex flex-wrap gap-3">
            {{ $actions }}
        </div>
    @endisset
</div>
