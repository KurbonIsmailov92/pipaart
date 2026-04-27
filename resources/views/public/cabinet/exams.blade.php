@extends('layouts.app')

@section('title', __('ui.cabinet.exams'))

@section('content')
    <x-ui.page-header :title="__('ui.cabinet.exams')" :description="__('ui.cabinet.exams_description')" :eyebrow="__('ui.cabinet.title')" />

    @include('public.cabinet._nav')

    <div class="grid gap-4">
        @forelse($exams as $exam)
            <x-ui.card>
                <p class="ui-kicker">{{ $exam->exam_date?->format('Y-m-d H:i') }}</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $exam->title }}</h2>
                <div class="mt-4 grid gap-2 text-sm text-slate-600 sm:grid-cols-2">
                    <p>{{ __('ui.forms.course') }}: {{ $exam->course?->title ?: '-' }}</p>
                    <p>{{ __('ui.cabinet.location') }}: {{ $exam->location ?: '-' }}</p>
                </div>
                @if($exam->description)
                    <p class="mt-4 text-sm text-slate-700">{{ $exam->description }}</p>
                @endif
            </x-ui.card>
        @empty
            <x-ui.card>
                <p class="text-slate-600">{{ __('ui.cabinet.no_exams') }}</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-6">{{ $exams->links() }}</div>
@endsection
