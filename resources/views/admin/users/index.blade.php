@extends('layouts.admin')

@section('title', 'Manage Users')
@section('page-title', 'Users')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.users.create') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-white">Add user</a>
    </div>

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">{{ $user->role?->label() }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">Edit</a>
                            @if(! auth()->user()->is($user))
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600" onclick="return confirm('Delete this user?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endsection
