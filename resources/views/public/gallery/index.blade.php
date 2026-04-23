@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="container mx-auto px-4 pt-10">
        <div class="mb-6 flex items-center justify-between gap-4">
            <h1 class="text-2xl font-bold">Gallery</h1>
            @can('create', \App\Models\Gallery::class)
                <a href="{{ route('admin.gallery.index') }}" class="rounded-xl bg-slate-900 px-4 py-3 text-sm text-white">Manage in CMS</a>
            @endcan
        </div>

        <div class="grid grid-cols-1 gap-6 text-center sm:grid-cols-2 lg:grid-cols-3">
            @forelse($photos as $photo)
                <div class="rounded-2xl bg-white p-4 shadow-md">
                    <a href="{{ route('gallery.show', $photo) }}">
                        <x-gallery-item :photo="$photo" />
                    </a>
                    <h3 class="mt-4 text-lg font-semibold">{{ $photo->title }}</h3>
                    <p class="mt-1 text-xs uppercase tracking-[0.3em] text-slate-400">{{ $photo->category }}</p>
                    <div class="mt-2 line-clamp-2 text-gray-600">{{ $photo->description }}</div>
                </div>
            @empty
                <p class="col-span-full text-slate-500">No gallery items found.</p>
            @endforelse
        </div>

        <x-image-viewer />

        <div class="mt-10">{{ $photos->links() }}</div>
    </div>
@endsection
