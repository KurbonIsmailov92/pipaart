@extends('layouts.app')

@section('title', 'Редактировать курс')

@section('content')
    <h1 class=" mt-6 text-primary text-2xl sm:text-4xl">Редактировать курс</h1>

    <div class="text-sm sm:text-base mt-6 space-y-6">
        <x-form.form method="POST" action="{{route('courses.update', ['id'=>$course->id])}}" class="pb-12">
            @method('PUT') <!-- Для отправки PUT-запроса -->
            @csrf

            <x-form.input label="Название курса"
                          name="title"
                          value="{{ old('title', $course->title) }}">
            </x-form.input>
            <x-form.textarea label="Описание курса"
                             name="description"
                             placeholder="Краткая информация о курсе">
                {{ old('description', $course->description) }}
            </x-form.textarea>
            <x-form.input label="Количество часов"
                          name="hours"
                          value="{{old('hours', $course->hours)}}">
            </x-form.input>
            <div class="space-x-6">
                <x-form.button>Сохранить</x-form.button>
                <a href="/courses/list" class="text hover:text-red-500 transition-colors duration-300">
                    Отмена
                </a>
            </div>
        </x-form.form>
    </div>
    <x-form.disable-button/>
@endsection
