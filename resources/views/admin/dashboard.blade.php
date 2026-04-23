@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach($stats as $label => $value)
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-500">{{ $label }}</p>
                <p class="mt-3 text-4xl font-semibold text-slate-900">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Latest Courses</h2>
                <a href="{{ route('admin.courses.index') }}" class="text-sm text-blue-600">Manage</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($latestCourses as $course)
                    <div class="rounded-xl border border-slate-200 px-4 py-3">
                        <p class="font-medium">{{ $course->title }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $course->hours }} hours</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No courses yet.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Latest News</h2>
                <a href="{{ route('admin.news.index') }}" class="text-sm text-blue-600">Manage</a>
            </div>
            <div class="mt-4 space-y-3">
                @forelse($latestNews as $news)
                    <div class="rounded-xl border border-slate-200 px-4 py-3">
                        <p class="font-medium">{{ $news->title }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $news->created_at?->format('M d, Y') }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No news posts yet.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
