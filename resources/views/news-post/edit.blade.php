@extends('layouts.app')

@section('title', 'Редактировать новость')

@section('content')
    @csrf
    <h1 class=" mt-6 text-primary text-2xl sm:text-4xl">Редактировать новость</h1>

    <div class="text-sm sm:text-base mt-6 space-y-6">
        <x-form.form method="POST" action="{{ route('news.update', ['id' => $resource->id]) }}" class="pb-12">
            @method('PUT') <!-- Для отправки PUT-запроса -->
            @csrf

            <x-form.input label="Заголовок новости"
                          name="title"
                          placeholder="Экзамены по CIPA прошли успешно"
                          value="{{ old('title', $resource->title) }}">
            </x-form.input>
            <x-form.textarea label="Текст новости"
                             name="text"
                             placeholder="Новость">{{ old('text', $resource->text) }}
            </x-form.textarea>

            <div class="space-x-6">
                <x-form.button>Сохранить</x-form.button>
                <a href="/news/list" class="text hover:text-red-500 transition-colors duration-300">
                    Отмена
                </a>
            </div>
        </x-form.form>
    </div>
    <x-form.disable-button/>
@endsection
