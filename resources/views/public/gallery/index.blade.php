@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    <x-ui.page-header title="Gallery" description="A visual archive of institute activity, events, and learning moments.">
        <x-slot:actions>
            @can('create', \App\Models\Gallery::class)
                <x-ui.button-link :href="route('admin.gallery.index')" variant="secondary">Manage in CMS</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
        @forelse($photos as $photo)
            <x-ui.card class="overflow-hidden p-0">
                <a href="{{ route('gallery.show', $photo) }}" class="block">
                    <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}" class="h-56 w-full object-cover">
                </a>
                <div class="p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $photo->category }}</p>
                    <h2 class="mt-3 text-xl font-semibold text-slate-950">{{ $photo->title }}</h2>
                    <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($photo->description, 140) }}</p>
                    <div class="mt-5">
                        <x-ui.button-link :href="route('gallery.show', $photo)" variant="ghost">Open Photo</x-ui.button-link>
                    </div>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="sm:col-span-2 xl:col-span-3">
                <p class="text-slate-500">No gallery items found.</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-10">{{ $photos->links() }}</div>
@endsection
