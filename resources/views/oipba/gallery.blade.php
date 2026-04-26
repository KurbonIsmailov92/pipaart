@extends('layouts.app')

@section('title', __('ui.gallery.title'))

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
    @endphp

    <h1 class="mt-6 text-2xl text-primary sm:text-4xl">{{ __('ui.gallery.title') }}</h1>

    <div class="mt-6 text-sm sm:text-base">
        <div class="mt-8 grid grid-cols-1 gap-6 text-center sm:grid-cols-2 lg:grid-cols-3">
            @forelse($photos as $photo)
                <a href="{{ route('gallery.show', ['locale' => $currentLocale, 'gallery' => $photo]) }}" class="block">
                    <x-gallery-item :photo="$photo" />
                </a>
            @empty
                <div class="rounded-xl border border-slate-200 bg-white p-8 text-slate-500 sm:col-span-2 lg:col-span-3">
                    {{ __('ui.gallery.empty') }}
                </div>
            @endforelse
        </div>
    </div>

    <x-image-viewer />
@endsection
