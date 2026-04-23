@extends('layouts.app')

@section('title', 'News')

@section('content')
    <x-ui.page-header title="News" description="Announcements, updates, and editorial content managed directly from the CMS.">
        <x-slot:actions>
            @can('create', \App\Models\NewsPost::class)
                <x-ui.button-link :href="route('admin.news.index')" variant="secondary">Manage in CMS</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <x-search :action="route('news.index')" name="search" placeholder="Search news..." />

    <div class="mt-8 grid gap-6">
        @forelse($newsPosts as $newsPost)
            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $newsPost->published_at?->format('M d, Y') }}</p>
                <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ $newsPost->title }}</h2>
                <p class="mt-4 text-slate-600">{{ \Illuminate\Support\Str::limit($newsPost->content, 220) }}</p>
                <div class="mt-5">
                    <x-ui.button-link :href="route('news.show', $newsPost)" variant="secondary">Read More</x-ui.button-link>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card>
                <p class="text-slate-500">No news posts found.</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-8">{{ $newsPosts->links() }}</div>
@endsection
