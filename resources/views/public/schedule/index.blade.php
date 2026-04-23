@extends('layouts.app')

@section('title', 'Schedule')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10">
        <div class="mb-8">
            <h1 class="text-4xl font-semibold text-slate-900">Schedule</h1>
            <p class="mt-2 text-slate-600">Upcoming training and certification sessions managed from the CMS.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($schedules as $schedule)
                <article class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $schedule->start_date?->format('M d, Y') }}</p>
                    <h2 class="mt-3 text-xl font-semibold">{{ $schedule->course?->title }}</h2>
                    <p class="mt-2 text-sm text-slate-500">Teacher: {{ $schedule->teacher }}</p>
                    <p class="mt-4 text-slate-700">{{ $schedule->schedule_text }}</p>
                </article>
            @empty
                <div class="rounded-2xl bg-white p-8 text-slate-500 shadow-sm md:col-span-2 xl:col-span-3">No schedule entries available yet.</div>
            @endforelse
        </div>
    </section>
@endsection
