@extends('layouts.admin')

@section('title', 'Manage Schedule')
@section('page-title', 'Schedule')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.schedules.create') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-white">Add schedule entry</a>
    </div>

    <div class="table-shell">
        <table class="data-table">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">Course</th>
                <th class="px-4 py-3">Start Date</th>
                <th class="px-4 py-3">Teacher</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($schedules as $schedule)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $schedule->course?->title }}</td>
                    <td class="px-4 py-3">{{ $schedule->start_date?->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">{{ $schedule->teacher }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Delete this schedule entry?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">No schedule entries found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $schedules->links() }}</div>
@endsection
