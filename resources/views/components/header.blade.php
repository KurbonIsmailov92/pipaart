@php
    $navItems = [
        ['label' => __('ui.nav.home'), 'route' => 'home'],
        ['label' => __('ui.nav.about'), 'route' => 'about'],
        ['label' => __('ui.nav.certifications'), 'route' => 'certifications'],
        ['label' => __('ui.nav.courses'), 'route' => 'courses.index'],
        ['label' => __('ui.nav.schedule'), 'route' => 'schedule.index'],
        ['label' => __('ui.nav.news'), 'route' => 'news.index'],
        ['label' => __('ui.nav.gallery'), 'route' => 'gallery.index'],
        ['label' => __('ui.nav.contact'), 'route' => 'contact'],
    ];

    $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
    $locales = \App\Support\LocalizedRoute::supportedLocales();
@endphp

<header class="relative z-50 mt-4 w-full text-white">
    <div class="shell-container">
        <div class="surface-card w-full border border-white/10 bg-[#143950]/70 px-4 py-3 text-white shadow-2xl sm:px-6">
            <div class="flex w-full items-center justify-between gap-3 lg:gap-6">
                <a href="{{ route('home') }}" class="min-w-0 flex-1 lg:max-w-[24rem]">
                    <x-logo />
                </a>

                <nav class="hidden min-w-0 flex-1 items-center justify-center gap-1 lg:flex">
                    @foreach($navItems as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            class="{{ $currentRoute === $item['route'] ? 'bg-white/[0.18] text-white' : 'text-white/[0.82] hover:bg-white/10 hover:text-white' }} whitespace-nowrap rounded-full px-3 py-2 text-sm font-semibold transition xl:px-4"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <details class="group relative flex-none lg:hidden">
                    <summary class="list-none rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur marker:hidden">
                        {{ __('ui.common.menu') }}
                    </summary>
                    <div class="absolute right-0 top-full mt-3 w-72 max-w-full overflow-hidden rounded-[2rem] border border-white/15 bg-[#143950]/95 p-4 shadow-2xl sm:w-80">
                        <div class="grid gap-2 text-sm">
                            @foreach($navItems as $item)
                                <a
                                    href="{{ route($item['route']) }}"
                                    class="{{ $currentRoute === $item['route'] ? 'bg-white/[0.18] text-white' : 'hover:bg-white/10' }} rounded-2xl px-4 py-3"
                                >
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </details>
            </div>
        </div>
    </div>
</header>
