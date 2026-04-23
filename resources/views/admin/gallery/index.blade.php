@extends('layouts.admin')

@section('title', 'Manage Gallery')
@section('page-title', 'Gallery')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.gallery.create') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-white">Add photo</a>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
        @forelse($photos as $photo)
            <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->title }}" class="h-52 w-full object-cover">
                <div class="p-5">
                    <h2 class="text-lg font-semibold">{{ $photo->title }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($photo->description, 120) }}</p>
                    <div class="mt-4 flex gap-3 text-sm">
                        <a href="{{ route('admin.gallery.edit', $photo) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.gallery.destroy', $photo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Delete this gallery item?')">Delete</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl bg-white p-10 text-center text-slate-500 shadow-sm ring-1 ring-slate-200 sm:col-span-2 xl:col-span-3">No gallery items found.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $photos->links() }}</div>
@endsection
