@extends('layouts.app')
@section('title', $photo->title)
@section('content')
<div class="container mx-auto px-4 pt-10 max-w-md">
    <a href="{{ route('gallery.index') }}" class="text-blue-700 hover:underline">⟵ Назад в галерею</a>
    <div class="bg-white rounded shadow p-6 mt-4 text-center">
        <img src="{{ asset('storage/gallery/'.$photo->image) }}" class="w-full object-contain mb-4 rounded" alt="{{$photo->title}}">
        <h2 class="text-xl font-bold mb-2">{{$photo->title}}</h2>
        <div class="mb-4 text-gray-700">{{$photo->description}}</div>
        @if(auth()->check() && auth()->user()->isAdmin())
            <div class="flex justify-center gap-2 mt-3">
                <a href="{{ route('gallery.edit', $photo->id) }}" class="bg-yellow-500 hover:bg-yellow-700 px-3 py-1 rounded text-white text-xs">Ред.</a>
                <form method="POST" action="{{ route('gallery.destroy', $photo->id) }}" onsubmit="return confirm('Удалить фото?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-700 hover:bg-red-900 px-3 py-1 rounded text-white text-xs">Удалить</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
