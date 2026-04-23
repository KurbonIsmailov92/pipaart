@extends('layouts.admin')

@section('title', 'Manage Pages')
@section('page-title', 'Pages')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.pages.create') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-white">Add page</a>
    </div>

    <div class="table-shell">
        <table class="data-table">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Slug</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($pages as $page)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $page->title }}</td>
                    <td class="px-4 py-3">{{ $page->slug }}</td>
                    <td class="px-4 py-3">{{ $page->is_published ? 'Published' : 'Draft' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Delete this page?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">No pages found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $pages->links() }}</div>
@endsection
