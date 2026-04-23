@extends('layouts.app')

@section('title', $newsPost->title)

@section('content')
    <div class="mx-auto mt-6 max-w-3xl">
        @if($newsPost->image)
            <img src="{{ Storage::url($newsPost->image) }}" alt="{{ $newsPost->title }}" class="mb-6 h-72 w-full rounded-2xl object-cover">
        @endif

        <h1 class="text-3xl font-bold text-gray-900">{{ $newsPost->title }}</h1>
        <p class="mt-2 text-gray-600">{{ $newsPost->created_at?->format('d.m.Y') }}</p>

        <div class="mt-6 text-lg text-gray-800">
            {{ $newsPost->text }}
        </div>

        <div class="mt-8 flex items-center justify-between gap-4">
            <a href="{{ route('news.list') }}" class="rounded-xl bg-slate-900 px-4 py-3 text-white">Back to news</a>
            @can('update', $newsPost)
                <a href="{{ route('admin.news.edit', $newsPost) }}" class="text-sm font-semibold text-blue-600">Edit in CMS</a>
            @endcan
        </div>
    </div>
@endsection
