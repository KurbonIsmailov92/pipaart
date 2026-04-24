@extends('layouts.admin')

@section('title', 'Manage News')
@section('page-title', 'News')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.news.create') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-white">Add news post</a>
    </div>

    <div class="space-y-4">
        @forelse($newsPosts as $newsPost)
            <article class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex min-w-0 gap-4">
                        @if($newsPost->image_url)
                            <img src="{{ $newsPost->image_url }}" alt="{{ $newsPost->title }}" class="h-24 w-24 flex-none rounded-2xl object-cover">
                        @endif
                        <div class="min-w-0">
                            <h2 class="text-xl font-semibold">{{ $newsPost->title }}</h2>
                            <p class="mt-2 max-w-3xl text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->content, 180) }}</p>
                            <p class="mt-2 text-xs uppercase tracking-[0.3em] text-slate-400">{{ $newsPost->published_at?->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3 text-sm">
                        <a href="{{ route('admin.news.edit', $newsPost) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.news.destroy', $newsPost) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Delete this post?')">Delete</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl bg-white p-10 text-center text-slate-500 shadow-sm ring-1 ring-slate-200">No news posts found.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $newsPosts->links() }}</div>
@endsection
