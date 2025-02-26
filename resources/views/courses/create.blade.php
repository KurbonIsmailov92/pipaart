@extends('layouts.app')

@section('title', 'Добавить новый курс')

@section('content')
    <h1 class=" mt-6 text-primary text-2xl sm:text-4xl">Добавить новый курс</h1>

    <div class="text-sm sm:text-base mt-6 space-y-6">
        <x-form.form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data" class="pb-12">
        @csrf
            <x-form.input label="Название курса" name="title" placeholder="Бухгалтерский учет"></x-form.input>
            <x-form.textarea label="Описание курса" name="description" placeholder="Краткая информация о курсе"></x-form.textarea>
            <x-form.input label="Количество часов" name="hours" placeholder="40"></x-form.input>

            <!-- Новое поле для загрузки фото -->
            <x-form.input type="file" label="Изображение курса" name="image"></x-form.input>

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

