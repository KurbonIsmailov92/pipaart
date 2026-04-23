@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <h1 class="mt-6 text-2xl text-primary sm:text-4xl">Courses</h1>
        @can('create', \App\Models\Course::class)
            <a href="{{ route('admin.courses.index') }}" class="rounded-xl bg-slate-900 px-4 py-3 text-sm text-white">Manage in CMS</a>
        @endcan
    </div>

    <div class="mt-6">
        <x-search />
    </div>

    <div class="mt-6 space-y-6 text-sm sm:text-base">
        @forelse($courses as $course)
            <x-course-item
                title="{{ $course->title }}"
                text="{{ $course->description }}"
                argc="{{ route('courses.show', $course) }}"
            >
                Course duration: {{ $course->hours }} hours
            </x-course-item>
        @empty
            <p>No courses found.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $courses->links() }}
    </div>
@endsection
