@php
    $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
    $locales = \App\Support\LocalizedRoute::supportedLocales();
@endphp


<div class="shell-container pt-4">
    
    <div class="flex flex-col gap-2 text-sm text-white/85 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-2 text-sm text-white/85 sm:flex-row sm:items-center sm:justify-start">
                            @foreach($locales as $locale)
                                <a
                                    href="{{ \App\Support\LocalizedRoute::switchUrl($locale) }}"
                                    class="{{ app()->getLocale() === $locale ? 'bg-white text-slate-900' : 'bg-white/10 text-white/85' }} rounded-full px-3 py-2 text-xs font-bold uppercase tracking-[0.3em]"
                                >
                                    {{ $locale }}
                                </a>
                            @endforeach
                        </div>
        @auth
            <div class="flex flex-wrap items-center justify-end gap-3">
                <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 backdrop-blur">{{ auth()->user()->name }}</span>
                <button type="button" class="pill-link theme-toggle" data-theme-toggle aria-label="Toggle color theme">
                    <span data-theme-label>Light</span>
                </button>
                @if(auth()->user()->hasRole(['admin', 'teacher']))
                    <a href="{{ route('admin.dashboard') }}" class="pill-link">{{ __('ui.common.admin_panel') }}</a>
                @endif
                <a href="{{ route('cabinet.index', ['locale' => app()->getLocale()]) }}" class="pill-link">{{ __('ui.cabinet.title') }}</a>
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="pill-link">{{ __('ui.common.logout') }}</button>
                </form>
            </div>
        @else
            <div class="flex flex-wrap items-center justify-end gap-3">
                <button type="button" class="pill-link theme-toggle" data-theme-toggle aria-label="Toggle color theme">
                    <span data-theme-label>Light</span>
                </button>
                <a href="{{ route('auth.register') }}" class="pill-link">{{ __('ui.common.register') }}</a>
                <a href="{{ route('auth.login') }}" class="pill-link">{{ __('ui.common.login') }}</a>
            </div>
        @endauth
    </div>
</div>
