@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="mx-auto mt-6 max-w-3xl">
        @if($course->image)
            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="mb-6 h-72 w-full rounded-2xl object-cover">
        @endif

        <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
        <p class="mt-2 text-sm uppercase tracking-[0.2em] text-slate-500">{{ $course->hours }} hours</p>

        <div class="mt-6 text-lg text-gray-800">
            {{ $course->description }}
        </div>

        <div class="mt-8 flex items-center justify-between gap-4">
            <a href="{{ route('courses.list') }}" class="rounded-xl bg-slate-900 px-4 py-3 text-white">Back to courses</a>
            @can('update', $course)
                <a href="{{ route('admin.courses.edit', $course) }}" class="text-sm font-semibold text-blue-600">Edit in CMS</a>
            @endcan
        </div>
    </div>
@endsection
