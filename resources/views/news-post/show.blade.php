@extends('layouts.app')

@section('title', $newsPost->title)

@section('content')
    <div class="max-w-3xl mx-auto mt-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $newsPost->title }}</h1>
        <p class="text-gray-600 mt-2">{{ $newsPost->created_at->format('d.m.Y') }}</p>
        <div class="mt-4 text-lg text-gray-800">
            {{ $newsPost->text }}
        </div>

        <div class="w-full flex justify-between items-center">
            <div class="mt-6">
                <x-form.button>
                    <a href="{{ route('news.list') }}">← Вернуться к новостям</a>
                </x-form.button>
            </div>

            <div class="space-x-4 flex">
                <a href="{{ route('news.edit', $newsPost->id) }}"
                   class="font-bold transition-colors duration-200 hover:text-blue-500 mr-2">
                    Редактировать
                </a>
                <form action="{{ route('news.delete', $newsPost->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="font-bold text-red-800 transition-colors duration-200 hover:text-red-500">
                        Удалить
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
