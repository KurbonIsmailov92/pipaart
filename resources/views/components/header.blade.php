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
    $currentLocale = request()->route('locale', app()->getLocale());
@endphp

<header class="site-header relative z-50 mt-4 w-full max-w-full overflow-x-hidden text-white">
    <div class="shell-container w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="surface-card w-full max-w-full border border-white/10 bg-[#143950]/70 px-4 py-3 text-white shadow-2xl sm:px-6">
            <div class="flex w-full min-w-0 max-w-full items-center justify-between gap-3 lg:gap-6">
                <a href="{{ route('home', ['locale' => $currentLocale]) }}" class="min-w-0 max-w-full flex-1 lg:max-w-[24rem]">
                    <x-logo />
                </a>

                <nav class="hidden min-w-0 flex-1 items-center justify-center gap-1 lg:flex">
                    @foreach($navItems as $item)
                        <a
                            href="{{ route($item['route'], ['locale' => $currentLocale]) }}"
                            class="{{ $currentRoute === $item['route'] ? 'bg-white/[0.18] text-white' : 'text-white/[0.82] hover:bg-white/10 hover:text-white' }} whitespace-nowrap rounded-full px-3 py-2 text-sm font-semibold transition xl:px-4"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <details class="mobile-nav group static max-w-full flex-none lg:hidden">
                    <summary class="inline-flex list-none w-auto max-w-full items-center justify-center rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-medium backdrop-blur marker:hidden sm:px-4 sm:py-2 sm:text-sm">
                        {{ __('ui.common.menu') }}
                    </summary>
                    <div class="absolute left-4 right-4 top-full z-50 mt-3 w-auto max-w-none overflow-hidden rounded-[2rem] border border-white/15 bg-[#143950]/95 p-3 shadow-2xl sm:left-6 sm:right-6 sm:p-4">
                        <div class="grid max-w-full gap-2 text-sm">
                            @foreach($navItems as $item)
                                <a
                                    href="{{ route($item['route'], ['locale' => $currentLocale]) }}"
                                    class="{{ $currentRoute === $item['route'] ? 'bg-white/[0.18] text-white' : 'hover:bg-white/10' }} block max-w-full rounded-2xl px-4 py-3"
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
