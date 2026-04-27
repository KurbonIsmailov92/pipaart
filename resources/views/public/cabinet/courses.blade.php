@extends('layouts.app')

@section('title', __('ui.cabinet.courses'))

@section('content')
    <x-ui.page-header :title="__('ui.cabinet.courses')" :description="__('ui.cabinet.courses_description')" :eyebrow="__('ui.cabinet.title')" />

    @include('public.cabinet._nav')

    <div class="grid gap-4">
        @forelse($enrollments as $enrollment)
            <x-ui.card>
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="ui-kicker">{{ $enrollment->status }}</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $enrollment->course?->title }}</h2>
                        <p class="mt-3 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit((string) $enrollment->course?->description, 180) }}</p>
                    </div>
                    <div class="text-sm text-slate-600 sm:text-right">
                        <p>{{ __('ui.cabinet.started_at') }}: {{ $enrollment->started_at?->format('Y-m-d') ?: '-' }}</p>
                        <p>{{ __('ui.cabinet.completed_at') }}: {{ $enrollment->completed_at?->format('Y-m-d') ?: '-' }}</p>
                    </div>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card>
                <p class="text-slate-600">{{ __('ui.cabinet.no_courses') }}</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-6">{{ $enrollments->links() }}</div>
@endsection
