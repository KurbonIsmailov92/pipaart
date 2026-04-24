<div {{ $attributes->merge(['class' => 'flex min-w-0 items-center gap-3 sm:gap-4']) }}>
    <span class="flex h-12 w-auto flex-none items-center justify-center sm:h-14 lg:h-16">
        <img
            class="h-full w-auto max-w-none object-contain"
            src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/logo.svg') }}"
            alt="{{ $siteSettings['site_name'] ?? 'PIPAA' }}"
        >
   

</div>
