@extends('layouts.app')

@section('title', __('ui.cabinet.schedule'))

@section('content')
    <x-ui.page-header :title="__('ui.cabinet.schedule')" :description="__('ui.cabinet.schedule_description')" :eyebrow="__('ui.cabinet.title')" />

    @include('public.cabinet._nav')

    <div class="grid gap-4">
        @forelse($schedules as $schedule)
            <x-ui.card>
                <p class="ui-kicker">{{ $schedule->starts_at?->format('Y-m-d H:i') }}</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $schedule->title }}</h2>
                <p class="mt-2 text-sm text-slate-600">{{ $schedule->course?->title }}</p>
                <div class="mt-4 grid gap-2 text-sm text-slate-600 sm:grid-cols-2">
                    <p>{{ __('ui.forms.teacher') }}: {{ $schedule->teacher ?: '-' }}</p>
                    <p>{{ __('ui.cabinet.location') }}: {{ $schedule->location ?: '-' }}</p>
                    <p>{{ __('ui.cabinet.ends_at') }}: {{ $schedule->ends_at?->format('Y-m-d H:i') ?: '-' }}</p>
                </div>
                @if($schedule->description)
                    <p class="mt-4 text-sm text-slate-700">{{ $schedule->description }}</p>
                @endif
            </x-ui.card>
        @empty
            <x-ui.card>
                <p class="text-slate-600">{{ __('ui.cabinet.no_schedule') }}</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-6">{{ $schedules->links() }}</div>
@endsection
