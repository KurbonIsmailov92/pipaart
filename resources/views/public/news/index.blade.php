@extends('layouts.app')

@section('title', __('ui.news.title'))

@section('content')
    @php
        $fallbackImage = \Illuminate\Support\Facades\Vite::asset('resources/images/news.jpg');
    @endphp

    <x-ui.page-header :title="__('ui.news.title')" :description="__('ui.news.description')" :eyebrow="__('ui.nav.news')">
        <x-slot:actions>
            @can('create', \App\Models\NewsPost::class)
                <x-ui.button-link :href="route('admin.news.index')" variant="secondary">{{ __('ui.common.manage_in_cms') }}</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <x-search :action="route('news.index')" name="search" :placeholder="__('ui.news.search_placeholder')" :value="request('search')" />

    <div class="mt-8 grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
        @forelse($newsPosts as $newsPost)
            <x-ui.card class="overflow-hidden p-0">
                <img
                    src="{{ $newsPost->image ? \Illuminate\Support\Facades\Storage::url($newsPost->image) : $fallbackImage }}"
                    alt="{{ $newsPost->title }}"
                    class="h-56 w-full object-cover"
                >
                <div class="p-6">
                    <p class="ui-kicker">{{ $newsPost->published_at?->format('M d, Y') }}</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $newsPost->title }}</h2>
                    <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->body, 170) }}</p>
                    <div class="mt-6">
                        <x-ui.button-link :href="route('news.show', $newsPost)" variant="ghost">{{ __('ui.common.read_more') }}</x-ui.button-link>
                    </div>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="lg:col-span-2 xl:col-span-3">
                <p class="text-slate-500">{{ __('ui.news.empty') }}</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-8">{{ $newsPosts->links() }}</div>
@endsection
