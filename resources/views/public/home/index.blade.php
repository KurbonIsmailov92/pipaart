@extends('layouts.app')

@section('title', $settings['site_name'])

@section('content')
    <section class="surface-card relative overflow-hidden px-6 py-10 sm:px-10 sm:py-14">
        <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.22),_transparent_60%)] lg:block"></div>
        <div class="relative grid gap-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div class="max-w-2xl">
                <p class="text-xs uppercase tracking-[0.4em] text-blue-700">Public Institute of Professional Accountants and Auditors</p>
                <h1 class="mt-4 text-4xl font-semibold leading-tight text-slate-950 sm:text-5xl">{{ $settings['hero_title'] }}</h1>
                <p class="mt-5 text-base text-slate-600 sm:text-lg">{{ $settings['hero_subtitle'] }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <x-ui.button-link :href="route('courses.index')">Browse Courses</x-ui.button-link>
                    <x-ui.button-link :href="route('schedule.index')" variant="secondary">View Schedule</x-ui.button-link>
                </div>
            </div>

            <div class="grid gap-4">
                @foreach($featuredCourses as $course)
                    <x-ui.card class="border border-blue-100/70 bg-white/90">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Featured Course</p>
                        <h2 class="mt-3 text-xl font-semibold text-slate-950">{{ $course->title }}</h2>
                        <p class="mt-2 text-sm text-slate-500">{{ $course->duration }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ number_format((float) $course->price, 2) }}</p>
                        <div class="mt-5">
                            <x-ui.button-link :href="route('courses.show', $course)" variant="ghost">Open Course</x-ui.button-link>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mt-12">
        <x-ui.page-header title="Latest News" description="Fresh updates from the institute, courses, and certification activity.">
            <x-slot:actions>
                <x-ui.button-link :href="route('news.index')" variant="secondary">All News</x-ui.button-link>
            </x-slot:actions>
        </x-ui.page-header>

        <div class="grid gap-6 lg:grid-cols-3">
            @foreach($featuredNews as $newsPost)
                <x-ui.card>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $newsPost->published_at?->format('M d, Y') }}</p>
                    <h2 class="mt-3 text-xl font-semibold text-slate-950">{{ $newsPost->title }}</h2>
                    <p class="mt-4 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->content, 150) }}</p>
                    <div class="mt-5">
                        <x-ui.button-link :href="route('news.show', $newsPost)" variant="ghost">Read More</x-ui.button-link>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    </section>

    <section class="mt-12">
        <x-ui.page-header title="Search the News" description="Find announcements, course updates, and institutional notices."></x-ui.page-header>
        <x-search :action="route('search')" name="q" placeholder="Search site news..." />
    </section>

    <section class="mt-12">
        <x-ui.page-header title="More Stories" description="A broader look at the institute’s recent activity."></x-ui.page-header>
        <div class="grid gap-6 lg:grid-cols-2">
            @foreach($archiveNews as $newsPost)
                <x-ui.card>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $newsPost->published_at?->format('M d, Y') }}</p>
                    <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ $newsPost->title }}</h2>
                    <p class="mt-4 text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->content, 220) }}</p>
                    <div class="mt-5">
                        <x-ui.button-link :href="route('news.show', $newsPost)" variant="secondary">Open Article</x-ui.button-link>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    </section>
@endsection
