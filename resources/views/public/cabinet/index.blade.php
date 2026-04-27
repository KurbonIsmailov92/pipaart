@extends('layouts.app')

@section('title', __('ui.cabinet.title'))

@section('content')
    <x-ui.page-header :title="__('ui.cabinet.title')" :description="__('ui.cabinet.description')" :eyebrow="__('ui.cabinet.eyebrow')" />

    @include('public.cabinet._nav')

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
        <x-ui.card>
            <p class="ui-kicker">{{ __('ui.cabinet.active_courses') }}</p>
            <p class="mt-3 text-4xl font-semibold text-slate-950">{{ $activeCoursesCount }}</p>
        </x-ui.card>
        <x-ui.card>
            <p class="ui-kicker">{{ __('ui.cabinet.upcoming_schedule') }}</p>
            <p class="mt-3 text-4xl font-semibold text-slate-950">{{ $upcomingScheduleCount }}</p>
        </x-ui.card>
        <x-ui.card>
            <p class="ui-kicker">{{ __('ui.cabinet.certificates') }}</p>
            <p class="mt-3 text-4xl font-semibold text-slate-950">{{ $certificatesCount }}</p>
        </x-ui.card>
        <x-ui.card>
            <p class="ui-kicker">{{ __('ui.cabinet.upcoming_exams') }}</p>
            <p class="mt-3 text-4xl font-semibold text-slate-950">{{ $upcomingExamsCount }}</p>
        </x-ui.card>
        <x-ui.card>
            <p class="ui-kicker">{{ __('ui.applications.pending') }}</p>
            <p class="mt-3 text-4xl font-semibold text-slate-950">{{ $pendingApplicationsCount }}</p>
        </x-ui.card>
    </div>
@endsection
