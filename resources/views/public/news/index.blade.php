@extends('layouts.app')

@section('title', 'News')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <h1 class="mt-6 text-2xl text-primary sm:text-4xl">News</h1>
        @can('create', \App\Models\NewsPost::class)
            <a href="{{ route('admin.news.index') }}" class="rounded-xl bg-slate-900 px-4 py-3 text-sm text-white">Manage in CMS</a>
        @endcan
    </div>

    <div class="mt-6">
        <x-search />
    </div>

    <div class="mt-6 space-y-6 text-sm sm:text-base">
        @forelse($newsPosts as $newsPost)
            <x-old-news title="{{ $newsPost->title }}">
                {{ \Illuminate\Support\Str::limit($newsPost->text, 200) }}
                <br><br>
                <a href="{{ route('news.show', $newsPost) }}" class="inline-flex rounded-xl bg-slate-900 px-4 py-3 text-sm text-white">
                    Read more
                </a>
            </x-old-news>
        @empty
            <p>No news posts found.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $newsPosts->links() }}
    </div>
@endsection
