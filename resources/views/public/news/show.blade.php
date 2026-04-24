@extends('layouts.app')

@section('title', $newsPost->title)

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
        $fallbackImage = \Illuminate\Support\Facades\Vite::asset('resources/images/news.jpg');
    @endphp

    <x-ui.page-header
        :title="$newsPost->title"
        :description="$newsPost->published_at?->format('F d, Y')"
        :eyebrow="__('ui.nav.news')"
    >
        <x-slot:actions>
            <x-ui.button-link :href="route('news.index', ['locale' => $currentLocale])" variant="secondary">{{ __('ui.common.back_to_news') }}</x-ui.button-link>
            @can('update', $newsPost)
                <x-ui.button-link :href="route('admin.news.edit', $newsPost)" variant="ghost">{{ __('ui.common.edit_in_cms') }}</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
        <x-ui.card class="ui-prose">
            <p>{{ $newsPost->body }}</p>
        </x-ui.card>

        <div class="grid gap-6">
            <x-ui.card class="overflow-hidden p-0">
                <img
                    src="{{ $newsPost->image ? \Illuminate\Support\Facades\Storage::url($newsPost->image) : $fallbackImage }}"
                    alt="{{ $newsPost->title }}"
                    class="h-80 w-full object-cover"
                >
            </x-ui.card>

            <x-ui.card class="bg-[linear-gradient(135deg,rgba(223,238,246,0.88),rgba(244,239,229,0.96))]">
                <p class="ui-kicker">{{ __('ui.common.preview') }}</p>
                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $newsPost->published_at?->format('F d, Y') }}</p>
                <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->body, 180) }}</p>
                <div class="mt-6">
                    <x-ui.button-link :href="route('contact', ['locale' => $currentLocale])">{{ __('ui.nav.contact') }}</x-ui.button-link>
                </div>
            </x-ui.card>
        </div>
    </div>
@endsection
