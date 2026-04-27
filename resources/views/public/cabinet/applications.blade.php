@extends('layouts.app')

@section('title', __('ui.applications.my_applications'))

@section('content')
    <x-ui.page-header :title="__('ui.applications.my_applications')" :description="__('ui.applications.my_applications_description')" :eyebrow="__('ui.cabinet.title')" />

    @include('public.cabinet._nav')

    <div class="grid gap-4">
        @forelse($applications as $application)
            <x-ui.card>
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="ui-kicker">{{ $application->created_at?->format('Y-m-d H:i') }}</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $application->course?->title }}</h2>
                        <p class="mt-2 text-sm font-semibold text-[#1f5f85]">{{ __('ui.applications.statuses.'.$application->status) }}</p>
                    </div>

                </div>

                @if($application->comment)
                    <p class="mt-4 text-sm text-slate-600">{{ $application->comment }}</p>
                @endif

                @if($application->admin_comment)
                    <div class="mt-4 rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                        <p class="font-semibold text-slate-950">{{ __('ui.applications.admin_comment') }}</p>
                        <p class="mt-2">{{ $application->admin_comment }}</p>
                    </div>
                @endif
            </x-ui.card>
        @empty
            <x-ui.card>
                <p class="text-slate-600">{{ __('ui.applications.empty') }}</p>
            </x-ui.card>
        @endforelse
    </div>

    <div class="mt-6">{{ $applications->links() }}</div>
@endsection
