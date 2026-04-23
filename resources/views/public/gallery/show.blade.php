@extends('layouts.app')

@section('title', $photo->title)

@section('content')
    <x-ui.page-header :title="$photo->title" :description="$photo->category">
        <x-slot:actions>
            <x-ui.button-link :href="route('gallery.index')" variant="secondary">Back to Gallery</x-ui.button-link>
            @can('update', $photo)
                <x-ui.button-link :href="route('admin.gallery.edit', $photo)" variant="ghost">Edit in CMS</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-[1fr_0.95fr]">
        <x-ui.card class="overflow-hidden p-0">
            <img src="{{ Storage::url($photo->image_path) }}" class="max-h-[38rem] w-full object-cover" alt="{{ $photo->title }}">
        </x-ui.card>

        <x-ui.card>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $photo->category }}</p>
            <p class="mt-4 text-slate-600">{{ $photo->description }}</p>
        </x-ui.card>
    </div>
@endsection
