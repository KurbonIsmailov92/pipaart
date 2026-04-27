@extends('layouts.admin')

@section('title', __('ui.admin.course_applications'))
@section('page-title', __('ui.admin.course_applications'))

@section('content')
    <x-ui.card class="mb-6">
        <form method="GET" action="{{ route('admin.course-applications.index') }}" class="grid gap-4 md:grid-cols-5" data-submit-lock="false">
            <select name="status" class="ui-input">
                <option value="">{{ __('ui.common.status') }}</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ __('ui.applications.statuses.'.$status) }}</option>
                @endforeach
            </select>

            <select name="course_id" class="ui-input">
                <option value="">{{ __('ui.forms.course') }}</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected((string) ($filters['course_id'] ?? '') === (string) $course->id)>{{ $course->title }}</option>
                @endforeach
            </select>

            <select name="user_id" class="ui-input">
                <option value="">{{ __('ui.forms.user') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected((string) ($filters['user_id'] ?? '') === (string) $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>

            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="ui-input">
            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="ui-input">

            <div class="md:col-span-5">
                <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ __('ui.common.search') }}</button>
            </div>
        </form>
    </x-ui.card>

    <div class="table-shell">
        <table class="data-table">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">{{ __('ui.forms.user') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.course') }}</th>
                <th class="px-4 py-3">{{ __('ui.common.status') }}</th>
                <th class="px-4 py-3">{{ __('ui.applications.submitted_at') }}</th>
                <th class="px-4 py-3 text-right">{{ __('ui.common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($applications as $application)
                <tr>
                    <td class="px-4 py-3">{{ $application->user?->name }}<br><span class="text-xs text-slate-500">{{ $application->user?->email }}</span></td>
                    <td class="px-4 py-3">{{ $application->course?->title }}</td>
                    <td class="px-4 py-3">{{ __('ui.applications.statuses.'.$application->status) }}</td>
                    <td class="px-4 py-3">{{ $application->created_at?->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.course-applications.show', $application) }}" class="text-blue-600">{{ __('ui.common.view') }}</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">{{ __('ui.admin.no_course_applications') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $applications->links() }}</div>
@endsection
