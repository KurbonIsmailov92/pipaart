@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="max-w-3xl mx-auto mt-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
        <div class="mt-4 text-lg text-gray-800">
            {{ $course->description }}
        </div>

        <div class="w-full flex justify-between items-center">
            <div class="mt-6">
                <x-form.button>
                    <a href="{{ route('courses.list') }}">← Назад</a>
                </x-form.button>
            </div>
            @if(auth()->check() && auth()->user()->isAdmin())
                <div class="space-x-4 flex">
                    <a href="{{ route('courses.edit', $course->id) }}"
                       class="font-bold transition-colors duration-200 hover:text-blue-500 mr-2">
                        Редактировать
                    </a>
                    <form action="{{ route('courses.delete', $course->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-bold text-red-800 transition-colors duration-200 hover:text-red-500">
                            Удалить
                        </button>
                    </form>
                </div>
            @endif
        </div>

    </div>
@endsection
