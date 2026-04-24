@extends('layouts.app')

@section('title', __('ui.news.search_results_title'))

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
    @endphp
    <x-ui.page-header
        :title="__('ui.news.search_results_title')"
        :description="$query ? __('ui.news.search_results_with_query', ['query' => $query]) : __('ui.news.search_results_description')"
        :eyebrow="__('ui.common.search')"
    />

    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="grid gap-6">
            @forelse($newsPosts as $newsPost)
                <x-ui.card>
                    <p class="ui-kicker">{{ $newsPost->published_at?->format('M d, Y') }}</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $newsPost->title }}</h2>
                    <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->body, 200) }}</p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <x-ui.button-link :href="route('news.show', ['locale' => $currentLocale, 'newsPost' => $newsPost])" variant="secondary">{{ __('ui.common.read_more') }}</x-ui.button-link>
                        <x-ui.button-link :href="route('home', ['locale' => $currentLocale])" variant="ghost">{{ __('ui.common.back_home') }}</x-ui.button-link>
                    </div>
                </x-ui.card>
            @empty
                <x-ui.card>
                    <p class="text-slate-500">{{ __('ui.news.empty') }}</p>
                </x-ui.card>
            @endforelse
        </div>

        <x-ui.card>
            <p class="ui-kicker">{{ __('ui.nav.courses') }}</p>
            <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ __('ui.nav.courses') }}</h2>
            <div class="mt-4 space-y-4">
                @forelse($courses as $course)
                    <div class="rounded-[1.4rem] border border-slate-200/70 p-4">
                        <p class="text-sm font-semibold text-slate-900">{{ $course->title }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($course->description, 90) }}</p>
                        <a href="{{ route('courses.show', ['locale' => $currentLocale, 'course' => $course]) }}" class="mt-3 inline-flex text-sm font-semibold text-[#1f5f85]">{{ __('ui.common.open_course') }}</a>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">{{ __('ui.courses.empty') }}</p>
                @endforelse
            </div>
        </x-ui.card>
    </div>

    <div class="mt-8">{{ $newsPosts->links() }}</div>
@endsection
