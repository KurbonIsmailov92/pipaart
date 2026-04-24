@extends('layouts.app')

@section('title', $settings['site_name'])

@section('content')
    @php
        $heroImage = \Illuminate\Support\Facades\Vite::asset('resources/images/bg.jpg');
        $programImages = [
            \Illuminate\Support\Facades\Vite::asset('resources/images/cipa.jpg'),
            \Illuminate\Support\Facades\Vite::asset('resources/images/cap.jpg'),
            \Illuminate\Support\Facades\Vite::asset('resources/images/stock.jpg'),
        ];
        $newsFallback = \Illuminate\Support\Facades\Vite::asset('resources/images/news.jpg');
    @endphp

    <section class="surface-card relative overflow-hidden px-6 py-8 sm:px-8 sm:py-10 lg:px-10 lg:py-12">
        <div class="absolute inset-0 bg-cover bg-center opacity-25" style="background-image:url('{{ $heroImage }}')"></div>
        <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(20,57,80,0.96)_0%,rgba(31,95,133,0.74)_48%,rgba(215,187,119,0.32)_100%)]"></div>
        <div class="ui-pattern absolute inset-0 opacity-20"></div>

        <div class="relative grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
            <div class="max-w-3xl text-white">
                <p class="text-xs font-semibold uppercase tracking-[0.42em] text-white/70">{{ __('ui.brand.institute_full') }}</p>
                <h1 class="mt-5 text-4xl font-semibold leading-tight sm:text-5xl lg:text-6xl">{{ $settings['hero_title'] }}</h1>
                <p class="mt-5 max-w-2xl text-base text-white/[0.78] sm:text-lg">{{ $settings['hero_subtitle'] }}</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <x-ui.button-link :href="route('courses.index')">{{ __('ui.home.browse_courses') }}</x-ui.button-link>
                    <x-ui.button-link :href="route('schedule.index')" variant="secondary">{{ __('ui.home.view_schedule') }}</x-ui.button-link>
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="ui-stat">
                        <p class="text-3xl font-semibold text-white">{{ $featuredCourses->count() }}</p>
                        <p class="mt-1 text-sm text-white/72">{{ __('ui.nav.courses') }}</p>
                    </div>
                    <div class="ui-stat">
                        <p class="text-3xl font-semibold text-white">{{ $featuredNews->count() + $archiveNews->count() }}</p>
                        <p class="mt-1 text-sm text-white/72">{{ __('ui.nav.news') }}</p>
                    </div>
                    <div class="ui-stat">
                        <p class="text-3xl font-semibold text-white">{{ $upcomingSchedules->count() }}</p>
                        <p class="mt-1 text-sm text-white/72">{{ __('ui.nav.schedule') }}</p>
                    </div>
                </div>
            </div>

            <div class="hero-visual-shell">
                <div class="hero-visual-glow"></div>
                <img
                    src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/logo.svg') }}"
                    alt="{{ $settings['site_name'] }}"
                    class="hero-visual-image"
                >

                @if($featuredCourses->isNotEmpty())
                    <div class="absolute inset-x-4 bottom-4 z-20 sm:inset-x-6 lg:bottom-6">
                        <x-ui.card class="border border-white/30 bg-white/90">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <p class="ui-kicker">{{ __('ui.home.featured_course') }}</p>
                                    <h2 class="mt-2 text-xl font-semibold text-slate-950">{{ $featuredCourses->first()->title }}</h2>
                                    <div class="mt-3 flex flex-wrap gap-3 text-sm text-slate-600">
                                        <span>{{ $featuredCourses->first()->duration_label }}</span>
                                        @if((float) $featuredCourses->first()->price > 0)
                                            <span>{{ number_format((float) $featuredCourses->first()->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>

                                <x-ui.button-link :href="route('courses.show', $featuredCourses->first())" variant="ghost">
                                    {{ __('ui.common.open_course') }}
                                </x-ui.button-link>
                            </div>
                        </x-ui.card>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <x-ui.section
        class="pt-10"
        :eyebrow="__('ui.nav.about')"
        :title="$aboutPage?->title ?? __('ui.nav.about')"
        :description="$aboutPage?->meta_description ?: __('ui.brand.footer_description')"
    >
        <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
            <x-ui.card>
                <div class="ui-prose">
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $aboutPage?->content), 520) }}</p>
                </div>
                <div class="mt-6">
                    <x-ui.button-link :href="route('about')" variant="secondary">{{ __('ui.nav.about') }}</x-ui.button-link>
                </div>
            </x-ui.card>

            <div class="grid gap-6">
                <x-ui.card class="overflow-hidden p-0">
                    <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/cap.jpg') }}" alt="{{ __('ui.nav.certifications') }}" class="h-48 w-full object-cover">
                    <div class="p-6">
                        <p class="ui-kicker">{{ __('ui.nav.certifications') }}</p>
                        <h3 class="mt-2 text-2xl font-semibold text-slate-950">{{ $certificationsPage?->title ?? __('ui.nav.certifications') }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags((string) $certificationsPage?->content), 150) }}</p>
                        <div class="mt-5">
                            <x-ui.button-link :href="route('certifications')" variant="ghost">{{ __('ui.nav.certifications') }}</x-ui.button-link>
                        </div>
                    </div>
                </x-ui.card>

                <x-ui.card class="bg-[linear-gradient(135deg,rgba(223,238,246,0.9),rgba(244,239,229,0.95))]">
                    <p class="ui-kicker">{{ __('ui.nav.contact') }}</p>
                    <h3 class="mt-2 text-2xl font-semibold text-slate-950">{{ $settings['site_name'] }}</h3>
                    <div class="mt-4 space-y-2 text-sm text-slate-700">
                        <p>{{ $settings['contact_email'] }}</p>
                        @if(! empty($settings['contact_phone']))
                            <p>{{ $settings['contact_phone'] }}</p>
                        @endif
                        <p>{{ $settings['contact_address'] }}</p>
                    </div>
                    <div class="mt-5">
                        <x-ui.button-link :href="route('contact')">{{ __('ui.nav.contact') }}</x-ui.button-link>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </x-ui.section>

    <x-ui.section
        :eyebrow="__('ui.nav.courses')"
        :title="__('ui.nav.courses')"
        :description="__('ui.courses.description')"
    >
        <x-slot:actions>
            <x-ui.button-link :href="route('courses.index')" variant="secondary">{{ __('ui.home.browse_courses') }}</x-ui.button-link>
        </x-slot:actions>

        <div class="grid gap-6 lg:grid-cols-3">
            @forelse($featuredCourses as $course)
                <x-ui.card class="overflow-hidden p-0">
                    <img
                        src="{{ $course->image_url ?: $programImages[$loop->index % count($programImages)] }}"
                        alt="{{ $course->title }}"
                        class="h-52 w-full object-cover"
                    >
                    <div class="p-6">
                        <p class="ui-kicker">{{ $course->duration_label }}</p>
                        <h3 class="mt-2 text-2xl font-semibold text-slate-950">{{ $course->title }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($course->description, 145) }}</p>
                        <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                            <span class="text-sm font-semibold text-[#1f5f85]">
                                {{ (float) $course->price > 0 ? number_format((float) $course->price, 2) : $course->duration_label }}
                            </span>
                            <x-ui.button-link :href="route('courses.show', $course)" variant="ghost">{{ __('ui.common.open_course') }}</x-ui.button-link>
                        </div>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card class="lg:col-span-3">
                    <p class="text-slate-600">{{ __('ui.courses.empty') }}</p>
                </x-ui.card>
            @endforelse
        </div>
    </x-ui.section>

    <x-ui.section
        :eyebrow="__('ui.home.latest_news_title')"
        :title="__('ui.home.latest_news_title')"
        :description="__('ui.home.latest_news_description')"
    >
        <x-slot:actions>
            <x-ui.button-link :href="route('news.index')" variant="secondary">{{ __('ui.home.all_news') }}</x-ui.button-link>
        </x-slot:actions>

        <div class="grid gap-6 lg:grid-cols-3">
            @forelse($featuredNews as $newsPost)
                <x-ui.card class="overflow-hidden p-0">
                    <img
                        src="{{ $newsPost->image_url ?: $newsFallback }}"
                        alt="{{ $newsPost->title }}"
                        class="h-52 w-full object-cover"
                    >
                    <div class="p-6">
                        <p class="ui-kicker">{{ $newsPost->published_at?->format('M d, Y') }}</p>
                        <h3 class="mt-2 text-2xl font-semibold text-slate-950">{{ $newsPost->title }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->body, 150) }}</p>
                        <div class="mt-5">
                            <x-ui.button-link :href="route('news.show', $newsPost)" variant="ghost">{{ __('ui.common.read_more') }}</x-ui.button-link>
                        </div>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card class="lg:col-span-3">
                    <p class="text-slate-600">{{ __('ui.news.empty') }}</p>
                </x-ui.card>
            @endforelse
        </div>
    </x-ui.section>

    <x-ui.section
        :eyebrow="__('ui.nav.schedule')"
        :title="__('ui.nav.schedule')"
        :description="__('ui.schedule.description')"
    >
        <div class="grid gap-6 lg:grid-cols-[0.92fr_1.08fr]">
            <x-ui.card class="overflow-hidden bg-[linear-gradient(160deg,rgba(20,57,80,0.96),rgba(31,95,133,0.84),rgba(215,187,119,0.35))] text-white">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-white/60">{{ __('ui.nav.contact') }}</p>
                <h3 class="mt-3 text-3xl font-semibold">{{ __('ui.contact.send_message_title') }}</h3>
                <p class="mt-4 max-w-md text-sm text-white/[0.76]">{{ __('ui.contact.send_message_description') }}</p>
                <div class="mt-6 space-y-3 text-sm text-white/[0.82]">
                    <p>{{ $settings['contact_email'] }}</p>
                    @if(! empty($settings['contact_phone']))
                        <p>{{ $settings['contact_phone'] }}</p>
                    @endif
                </div>
                <div class="mt-8 flex flex-wrap gap-3">
                    <x-ui.button-link :href="route('contacts.message')" variant="secondary">{{ __('ui.contact.open_form') }}</x-ui.button-link>
                    <x-ui.button-link :href="route('contact')" variant="ghost" class="bg-white/10 text-white hover:bg-white/20">{{ __('ui.nav.contact') }}</x-ui.button-link>
                </div>
            </x-ui.card>

            <div class="grid gap-4">
                @forelse($upcomingSchedules as $schedule)
                    <x-ui.card class="bg-white/[0.86]">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="ui-kicker">{{ $schedule->start_date?->format('M d, Y') }}</p>
                                <h3 class="mt-2 text-xl font-semibold text-slate-950">{{ $schedule->course?->title }}</h3>
                                @if($schedule->teacher)
                                    <p class="mt-2 text-sm text-slate-600">{{ __('ui.schedule.teacher') }}: {{ $schedule->teacher }}</p>
                                @endif
                            </div>
                            <a href="{{ route('schedule.index') }}" class="text-sm font-semibold text-[#1f5f85]">{{ __('ui.home.view_schedule') }}</a>
                        </div>
                        <p class="mt-4 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($schedule->schedule_text, 150) }}</p>
                    </x-ui.card>
                @empty
                    <x-ui.card>
                        <p class="text-slate-600">{{ __('ui.schedule.empty') }}</p>
                    </x-ui.card>
                @endforelse
            </div>
        </div>
    </x-ui.section>

    <x-ui.section
        :eyebrow="__('ui.home.search_title')"
        :title="__('ui.home.search_title')"
        :description="__('ui.home.search_description')"
    >
        <x-search :action="route('search')" name="q" :placeholder="__('ui.home.search_placeholder')" />
    </x-ui.section>
@endsection
