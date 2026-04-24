@extends('layouts.app')

@section('title', $photo->title)

@section('content')
    @php
        $imageUrl = $photo->image_url ?: \Illuminate\Support\Facades\Vite::asset('resources/images/cap.jpg');
    @endphp

    <x-ui.page-header :title="$photo->title" :description="$photo->category" :eyebrow="__('ui.nav.gallery')">
        <x-slot:actions>
            <x-ui.button-link :href="route('gallery.index')" variant="secondary">{{ __('ui.common.back_to_gallery') }}</x-ui.button-link>
            @can('update', $photo)
                <x-ui.button-link :href="route('admin.gallery.edit', $photo)" variant="ghost">{{ __('ui.common.edit_in_cms') }}</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-[1.12fr_0.88fr]">
        <x-ui.card class="overflow-hidden p-0">
            <img src="{{ $imageUrl }}" class="max-h-[42rem] w-full object-cover" alt="{{ $photo->title }}">
        </x-ui.card>

        <x-ui.card>
            <p class="ui-kicker">{{ $photo->category }}</p>
            <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $photo->title }}</h2>
            <p class="mt-4 text-slate-600">{{ $photo->description }}</p>
            <div class="mt-8">
                <x-ui.button-link :href="route('contact')">{{ __('ui.nav.contact') }}</x-ui.button-link>
            </div>
        </x-ui.card>
    </div>
@endsection
