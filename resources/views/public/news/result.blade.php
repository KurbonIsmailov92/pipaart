@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <h1 class="mt-6 text-2xl text-primary sm:text-4xl">Search Results</h1>
    </div>

    <div class="mt-6 space-y-6 text-sm sm:text-base">
        @forelse($newsPosts as $newsPost)
            <x-old-news title="{{ $newsPost->title }}">
                {{ \Illuminate\Support\Str::limit($newsPost->content, 200) }}
                <br>
                <br>
                <x-form.button class="mt-3">
                    <a href="{{ route('news.show', $newsPost) }}">Read more →</a>
                </x-form.button>
            </x-old-news>
        @empty
            <p>No results found.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $newsPosts->links() }}
    </div>

    <div class="mt-6">
        <x-form.button>
            <a href="{{ route('home') }}">Back to home</a>
        </x-form.button>
    </div>
@endsection
