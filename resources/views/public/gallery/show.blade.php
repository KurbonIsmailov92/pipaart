@extends('layouts.app')

@section('title', $photo->title)

@section('content')
    <div class="container mx-auto max-w-3xl px-4 pt-10">
        <a href="{{ route('gallery.index') }}" class="text-blue-700 hover:underline">Back to gallery</a>
        <div class="mt-4 rounded-2xl bg-white p-6 text-center shadow">
            <img src="{{ Storage::url($photo->image_path) }}" class="mb-4 w-full rounded object-contain" alt="{{ $photo->title }}">
            <h2 class="mb-2 text-xl font-bold">{{ $photo->title }}</h2>
            <p class="mb-2 text-xs uppercase tracking-[0.3em] text-slate-400">{{ $photo->category }}</p>
            <div class="mb-4 text-gray-700">{{ $photo->description }}</div>
            @can('update', $photo)
                <a href="{{ route('admin.gallery.edit', $photo) }}" class="text-sm font-semibold text-blue-600">Edit in CMS</a>
            @endcan
        </div>
    </div>
@endsection
