@extends('layouts.app')

@section('title', __('ui.courses.title'))

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
        $fallbackImages = [
            \Illuminate\Support\Facades\Vite::asset('resources/images/cipa.jpg'),
            \Illuminate\Support\Facades\Vite::asset('resources/images/cap.jpg'),
            \Illuminate\Support\Facades\Vite::asset('resources/images/stock.jpg'),
        ];
    @endphp

    <x-ui.page-header :title="__('ui.courses.title')" :description="__('ui.courses.description')" :eyebrow="__('ui.nav.courses')">
        <x-slot:actions>
            @can('create', \App\Models\Course::class)
                <x-ui.button-link :href="route('admin.courses.index')" variant="secondary">{{ __('ui.common.manage_in_cms') }}</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <x-search :action="route('courses.index', ['locale' => $currentLocale])" name="search" :placeholder="__('ui.courses.search_placeholder')" :value="request('search')" />

    <div class="mt-8 grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
        @forelse($courses as $course)
            <x-ui.card class="overflow-hidden p-0">
                <img
                    src="{{ $course->image_url ?: $fallbackImages[$loop->index % count($fallbackImages)] }}"
                    alt="{{ $course->title }}"
                    class="h-56 w-full object-cover"
                >
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-3 text-sm font-medium text-[#1f5f85]">
                        <span>{{ $course->duration_label }}</span>
                        @if((float) $course->price > 0)
                            <span>{{ number_format((float) $course->price, 2) }}</span>
                        @endif
                    </div>
                    <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ $course->title }}</h2>
                    <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($course->description, 160) }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <x-ui.button-link :href="route('courses.show', ['locale' => $currentLocale, 'course' => $course])">{{ __('ui.common.open_course') }}</x-ui.button-link>
                        <x-ui.button-link :href="route('contact', ['locale' => $currentLocale])" variant="ghost">{{ __('ui.nav.contact') }}</x-ui.button-link>
                    </div>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="lg:col-span-2 xl:col-span-3">
                <p class="text-slate-500">{{ __('ui.courses.empty') }}</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-8">{{ $courses->links() }}</div>
@endsection
