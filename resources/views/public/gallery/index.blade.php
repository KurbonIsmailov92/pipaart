@extends('layouts.app')

@section('title', __('ui.gallery.title'))

@section('content')
    <x-ui.page-header :title="__('ui.gallery.title')" :description="__('ui.gallery.description')" :eyebrow="__('ui.nav.gallery')">
        <x-slot:actions>
            @can('create', \App\Models\Gallery::class)
                <x-ui.button-link :href="route('admin.gallery.index')" variant="secondary">{{ __('ui.common.manage_in_cms') }}</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @forelse($photos as $photo)
            @php
                $imageUrl = $photo->image_url ? \Illuminate\Support\Facades\Storage::url($photo->image_url) : \Illuminate\Support\Facades\Vite::asset('resources/images/cap.jpg');
            @endphp

            <a href="{{ route('gallery.show', $photo) }}" class="group block overflow-hidden rounded-[2rem] bg-white shadow-[0_18px_45px_rgba(24,52,74,0.14)]">
                <div class="overflow-hidden">
                    <img src="{{ $imageUrl }}" alt="{{ $photo->title }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
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

    <div class="mt-10">{{ $photos->links() }}</div>
@endsection
