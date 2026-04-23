@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <x-ui.page-header title="Courses" description="Professional training programs managed through the CMS and designed for modern accounting and finance careers.">
        <x-slot:actions>
            @can('create', \App\Models\Course::class)
                <x-ui.button-link :href="route('admin.courses.index')" variant="secondary">Manage in CMS</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <x-search :action="route('courses.index')" name="search" placeholder="Search courses..." />

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        @forelse($courses as $course)
            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $course->duration }}</p>
                <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ $course->title }}</h2>
                <p class="mt-4 text-slate-600">{{ \Illuminate\Support\Str::limit($course->description, 220) }}</p>
                <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-sm font-medium text-blue-900">{{ number_format((float) $course->price, 2) }}</span>
                    <x-ui.button-link :href="route('courses.show', $course)" variant="secondary">Open Course</x-ui.button-link>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="lg:col-span-2">
                <p class="text-slate-500">No courses found.</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-8">{{ $courses->links() }}</div>
@endsection
