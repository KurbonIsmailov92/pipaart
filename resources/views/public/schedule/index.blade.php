@extends('layouts.app')

@section('title', 'Schedule')

@section('content')
    <x-ui.page-header title="Schedule" description="Upcoming training and certification sessions managed from the CMS."></x-ui.page-header>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($schedules as $schedule)
            <x-ui.card>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $schedule->start_date?->format('M d, Y') }}</p>
                <h2 class="mt-3 text-xl font-semibold text-slate-950">{{ $schedule->course?->title }}</h2>
                <p class="mt-2 text-sm text-slate-500">Teacher: {{ $schedule->teacher }}</p>
                <p class="mt-4 text-slate-600">{{ $schedule->schedule_text }}</p>
            </x-ui.card>
        @empty
            <x-ui.card class="md:col-span-2 xl:col-span-3">
                <p class="text-slate-500">No schedule entries available yet.</p>
            </x-ui.card>
        @endforelse
    </div>
@endsection
