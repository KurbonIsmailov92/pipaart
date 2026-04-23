@extends('layouts.app')

@section('title', $newsPost->title)

@section('content')
    <x-ui.page-header :title="$newsPost->title" :description="$newsPost->published_at?->format('F d, Y')">
        <x-slot:actions>
            <x-ui.button-link :href="route('news.index')" variant="secondary">Back to News</x-ui.button-link>
            @can('update', $newsPost)
                <x-ui.button-link :href="route('admin.news.edit', $newsPost)" variant="ghost">Edit in CMS</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
        <x-ui.card>
            <div class="prose prose-slate max-w-none">
                <p>{{ $newsPost->content }}</p>
            </div>
        </x-ui.card>

        <x-ui.card class="overflow-hidden p-0">
            @if($newsPost->image)
                <img src="{{ Storage::url($newsPost->image) }}" alt="{{ $newsPost->title }}" class="h-80 w-full object-cover">
            @else
                <div class="flex h-80 items-center justify-center bg-slate-100 text-slate-400">News image</div>
            @endif
        </x-ui.card>
    </div>
@endsection
