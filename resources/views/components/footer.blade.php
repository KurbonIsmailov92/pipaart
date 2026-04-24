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
    $currentLocale = request()->route('locale', app()->getLocale());
@endphp

<footer class="mt-16 bg-[#143950] pb-8 pt-14 text-sm text-slate-100">
    <div class="shell-container">
        <div class="surface-card overflow-hidden border border-white/10 bg-white/[0.08] p-8 text-white backdrop-blur md:p-10">
            <div class="grid gap-10 lg:grid-cols-[1.25fr_0.8fr_0.95fr]">
                <div>
                    <x-logo />
                    <p class="mt-6 max-w-xl text-sm leading-7 text-white/[0.78]">
                        {{ __('ui.brand.footer_description') }}
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('courses.index', ['locale' => $currentLocale]) }}" class="pill-link">{{ __('ui.home.browse_courses') }}</a>
                        <a href="{{ route('contact', ['locale' => $currentLocale]) }}" class="pill-link">{{ __('ui.nav.contact') }}</a>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-white/60">{{ __('ui.common.preview') }}</p>
                    <div class="mt-4 grid gap-2">
                        @foreach($navItems as $item)
                            <a href="{{ route($item['route'], ['locale' => $currentLocale]) }}" class="text-white/[0.78] hover:text-white">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-white/60">{{ __('ui.contact.title') }}</p>
                    <div class="mt-4 space-y-3 text-white/[0.78]">
                        <p>{{ $siteSettings['contact_email'] ?? 'info@pipaa.tj' }}</p>
                        @if(! empty($siteSettings['contact_backup_email']))
                            <p>{{ $siteSettings['contact_backup_email'] }}</p>
                        @endif
                        @if(! empty($siteSettings['contact_phone']))
                            <p>{{ $siteSettings['contact_phone'] }}</p>
                        @endif
                        <p>{{ $siteSettings['contact_address'] ?? __('ui.contact.default_address') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col gap-3 text-xs uppercase tracking-[0.25em] text-white/50 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} {{ $siteSettings['site_name'] ?? 'PIPAA CMS' }}</p>
            <p>{{ __('ui.brand.institute_full') }}</p>
        </div>
    </div>
</footer>
