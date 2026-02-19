@extends('layouts.app')
@section('title', 'Фотогалерея')
@section('content')
    <div class="container mx-auto px-4 pt-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Фотогалерея</h1>
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('gallery.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Добавить фото</a>
            @endif
        </div>
        <div class="text-sm sm:text-base mt-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 text-center">
                @foreach($photos as $photo)
                <div class="bg-white rounded shadow-md p-3 relative">
                    <a href="{{ route('gallery.show', $photo->id) }}">
                        <x-gallery-item></x-gallery-item>
                    </a>
                </div>
            </div>
            <x-image-viewer/>
                    <h3 class="font-semibold text-lg mb-1">{{$photo->title}}</h3>
                    <div class="line-clamp-2 text-gray-600 mb-2">{{$photo->description}}</div>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <div class="flex gap-2 absolute top-2 right-2">
                            <a href="{{ route('gallery.edit', $photo->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-xs px-2 py-1 rounded text-white">Ред.</a>
                            <form method="POST" action="{{ route('gallery.destroy', $photo->id) }}" onsubmit="return confirm('Удалить фото?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-xs px-2 py-1 rounded text-white">X</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mt-10">{{$photos->links()}}</div>
    </div>
@endsection
