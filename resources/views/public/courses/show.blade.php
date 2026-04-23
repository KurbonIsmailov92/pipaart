@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <x-ui.page-header :title="$course->title" :description="$course->duration.' | '.number_format((float) $course->price, 2)">
        <x-slot:actions>
            <x-ui.button-link :href="route('courses.index')" variant="secondary">Back to Courses</x-ui.button-link>
            @can('update', $course)
                <x-ui.button-link :href="route('admin.courses.edit', $course)" variant="ghost">Edit in CMS</x-ui.button-link>
            @endcan
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <x-ui.card>
            <div class="prose prose-slate max-w-none">
                <p>{{ $course->description }}</p>
            </div>
        </x-ui.card>

        <x-ui.card class="overflow-hidden p-0">
            @if($course->image)
                <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="h-80 w-full object-cover">
            @else
                <div class="flex h-80 items-center justify-center bg-slate-100 text-slate-400">Course image</div>
            @endif
        </x-ui.card>
    </div>
@endsection
