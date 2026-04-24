@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: '')

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
        $isAbout = $page->slug === 'about';
        $pageImage = $isAbout
            ? \Illuminate\Support\Facades\Vite::asset('resources/images/cipa.jpg')
            : \Illuminate\Support\Facades\Vite::asset('resources/images/cap.jpg');
    @endphp

    <x-ui.page-header
        :title="$page->title"
        :description="$page->meta_description"
        :eyebrow="$isAbout ? __('ui.nav.about') : __('ui.nav.certifications')"
    />

    <div class="grid gap-6 lg:grid-cols-[1.08fr_0.92fr]">
        <x-ui.card class="ui-prose">
            {!! nl2br(e($page->content)) !!}
        </x-ui.card>

        <div class="grid gap-6">
            <x-ui.card class="overflow-hidden p-0">
                <img src="{{ $pageImage }}" alt="{{ $page->title }}" class="h-72 w-full object-cover">
            </x-ui.card>

            <x-ui.card class="bg-[linear-gradient(135deg,rgba(223,238,246,0.88),rgba(244,239,229,0.96))]">
                <p class="ui-kicker">{{ __('ui.common.preview') }}</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $page->title }}</h2>
                <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags((string) $page->content), 180) }}</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <x-ui.button-link :href="route('courses.index', ['locale' => $currentLocale])">{{ __('ui.nav.courses') }}</x-ui.button-link>
                    <x-ui.button-link :href="route('contact', ['locale' => $currentLocale])" variant="secondary">{{ __('ui.nav.contact') }}</x-ui.button-link>
                </div>
            </x-ui.card>
        </div>
    </div>
@endsection
