<div {{ $attributes->merge(['class' => 'flex min-w-0 max-w-full items-center gap-3 sm:gap-4']) }}>
    <span class="flex h-11 w-auto max-w-full flex-none items-center justify-center sm:h-12 lg:h-14">
        <img
            class="h-full w-auto max-w-full object-contain"
            src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/logo.svg') }}"
            alt="{{ $siteSettings['site_name'] ?? 'PIPAA' }}"
        >
    </span>
</div>
