@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <x-ui.page-header title="Search Results" description="News articles matching your query."></x-ui.page-header>

    <div class="grid gap-6">
        @forelse($newsPosts as $newsPost)
            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $newsPost->published_at?->format('M d, Y') }}</p>
                <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ $newsPost->title }}</h2>
                <p class="mt-4 text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->content, 200) }}</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <x-ui.button-link :href="route('news.show', $newsPost)" variant="secondary">Read More</x-ui.button-link>
                    <x-ui.button-link :href="route('home')" variant="ghost">Back Home</x-ui.button-link>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card>
                <p class="text-slate-500">No results found.</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-8">{{ $newsPosts->links() }}</div>
@endsection
