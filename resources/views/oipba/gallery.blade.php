@extends('layouts.app')

@section('title', 'OIPBA Gallery')

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
        $fallbackImage = \Illuminate\Support\Facades\Vite::asset('resources/images/cap.jpg');
    @endphp

    <x-ui.page-header title="OIPBA Gallery" :description="__('ui.gallery.description')" eyebrow="OIPBA" />

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @forelse($photos as $photo)
            <a
                href="{{ route('gallery.show', ['locale' => $currentLocale, 'gallery' => $photo]) }}"
                class="group block overflow-hidden rounded-[2rem] bg-white shadow-[0_18px_45px_rgba(24,52,74,0.14)]"
            >
                <div class="overflow-hidden">
                    <img
                        src="{{ $photo->image_url ?: $fallbackImage }}"
                        alt="{{ $photo->title }}"
                        loading="lazy"
                        decoding="async"
                        class="h-64 w-full object-cover transition duration-500 group-hover:scale-105"
                    >
                </div>
                <div class="p-5">
                    <p class="ui-kicker">{{ $photo->category }}</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-950">{{ $photo->title }}</h2>
                    <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($photo->description, 120) }}</p>
                </div>
            </a>
        @empty
            <x-ui.card class="sm:col-span-2 xl:col-span-3">
                <p class="text-slate-500">{{ __('ui.gallery.empty') }}</p>
            </x-ui.card>
        @endforelse
    </div>
@endsection
