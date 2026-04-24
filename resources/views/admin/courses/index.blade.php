@extends('layouts.admin')

@section('title', 'Manage Courses')
@section('page-title', 'Courses')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.courses.create') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-white">Add course</a>
    </div>

    <div class="table-shell">
        <table class="data-table">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Duration</th>
                <th class="px-4 py-3">Price</th>
                <th class="px-4 py-3">Updated</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($courses as $course)
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($course->image_url)
                                <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="h-12 w-12 flex-none rounded-xl object-cover">
                            @endif
                            <span class="font-medium">{{ $course->title }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">{{ $course->duration }}</td>
                    <td class="px-4 py-3">{{ number_format((float) $course->price, 2) }}</td>
                    <td class="px-4 py-3">{{ $course->updated_at?->diffForHumans() }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Delete this course?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No courses found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $courses->links() }}</div>
@endsection
