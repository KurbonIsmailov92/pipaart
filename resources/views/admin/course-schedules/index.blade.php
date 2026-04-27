@extends('layouts.admin')

@section('title', __('ui.admin.course_schedules'))
@section('page-title', __('ui.admin.course_schedules'))

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.course-schedules.create') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ __('ui.admin.create_course_schedule') }}</a>
    </div>

    <div class="table-shell">
        <table class="data-table">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">{{ __('ui.forms.title') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.course') }}</th>
                <th class="px-4 py-3">{{ __('ui.cabinet.starts_at') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.teacher') }}</th>
                <th class="px-4 py-3 text-right">{{ __('ui.common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($schedules as $schedule)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $schedule->title }}</td>
                    <td class="px-4 py-3">{{ $schedule->course?->title }}</td>
                    <td class="px-4 py-3">{{ $schedule->starts_at?->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-3">{{ $schedule->teacher ?: '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.course-schedules.edit', $schedule) }}" class="text-blue-600">{{ __('ui.common.edit') }}</a>
                            <form action="{{ route('admin.course-schedules.destroy', $schedule) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick='return confirm(@js(__('ui.common.confirm_delete')))'>{{ __('ui.common.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">{{ __('ui.admin.no_course_schedules') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $schedules->links() }}</div>
@endsection
