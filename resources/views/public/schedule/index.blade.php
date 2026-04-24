@extends('layouts.app')

@section('title', __('ui.schedule.title'))

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
    @endphp
    <x-ui.page-header :title="__('ui.schedule.title')" :description="__('ui.schedule.description')" :eyebrow="__('ui.nav.schedule')" />

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($schedules as $schedule)
            <x-ui.card class="bg-white/[0.92]">
                <p class="ui-kicker">{{ $schedule->start_date?->format('M d, Y') }}</p>
                <h2 class="mt-2 text-xl font-semibold text-slate-950">{{ $schedule->course?->title }}</h2>
                @if($schedule->teacher)
                    <p class="mt-3 text-sm font-medium text-[#1f5f85]">{{ __('ui.schedule.teacher') }}: {{ $schedule->teacher }}</p>
                @endif
                <p class="mt-4 text-sm text-slate-600">{{ $schedule->schedule_text }}</p>
                <div class="mt-6">
                    <x-ui.button-link :href="route('contact', ['locale' => $currentLocale])" variant="ghost">{{ __('ui.nav.contact') }}</x-ui.button-link>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="md:col-span-2 xl:col-span-3">
                <p class="text-slate-500">{{ __('ui.schedule.empty') }}</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-8">{{ $schedules->links() }}</div>
@endsection
