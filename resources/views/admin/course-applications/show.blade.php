@extends('layouts.admin')

@section('title', __('ui.admin.course_applications'))
@section('page-title', __('ui.admin.course_application_details'))

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.course-applications.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">{{ __('ui.common.back') }}</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <x-ui.card>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.forms.user') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $application->user?->name }} ({{ $application->user?->email }})</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.forms.course') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $application->course?->title }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.common.status') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ __('ui.applications.statuses.'.$application->status) }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.applications.submitted_at') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $application->created_at?->format('Y-m-d H:i') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.applications.reviewed_by') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $application->reviewer?->name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.applications.reviewed_at') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $application->reviewed_at?->format('Y-m-d H:i') ?: '-' }}</dd>
                </div>
            </dl>
        </x-ui.card>

        <div class="grid gap-6">
            <x-ui.card>
                <h2 class="text-xl font-semibold text-slate-950">{{ __('ui.applications.comment') }}</h2>
                <p class="mt-4 whitespace-pre-line text-slate-700">{{ $application->comment ?: '-' }}</p>
            </x-ui.card>

            <x-ui.card>
                <h2 class="text-xl font-semibold text-slate-950">{{ __('ui.applications.admin_comment') }}</h2>
                <p class="mt-4 whitespace-pre-line text-slate-700">{{ $application->admin_comment ?: '-' }}</p>
            </x-ui.card>

            @if($application->isPending())
                <x-ui.card>
                    <h2 class="text-xl font-semibold text-slate-950">{{ __('ui.admin.review_application') }}</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <form method="POST" action="{{ route('admin.course-applications.approve', $application) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <textarea name="admin_comment" rows="4" class="ui-input" placeholder="{{ __('ui.applications.admin_comment') }}">{{ old('admin_comment') }}</textarea>
                            <button type="submit" class="rounded-xl bg-emerald-700 px-4 py-3 text-white">{{ __('ui.applications.approve') }}</button>
                        </form>

                        <form method="POST" action="{{ route('admin.course-applications.reject', $application) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <textarea name="admin_comment" rows="4" class="ui-input" placeholder="{{ __('ui.applications.rejection_reason') }}">{{ old('admin_comment') }}</textarea>
                            <button type="submit" class="rounded-xl bg-red-600 px-4 py-3 text-white">{{ __('ui.applications.reject') }}</button>
                        </form>
                    </div>
                </x-ui.card>
            @endif
        </div>
    </div>
@endsection
