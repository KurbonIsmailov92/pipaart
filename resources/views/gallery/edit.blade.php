@extends('layouts.app')
@section('title', 'Редактировать фото')
@section('content')
<div class="container mx-auto px-4 pt-10 max-w-sm">
    <h1 class="text-xl font-bold mb-5">Редактировать фото</h1>
    <x-form.form method="POST" action="{{ route('gallery.update', $photo->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <x-form.input name="title" label="Название" value="{{ old('title', $photo->title) }}" placeholder="Название фото" />
            <x-form.error>@error('title'){{ $message }}@enderror</x-form.error>
        </div>
        <div class="mt-4">
            <x-form.input name="description" label="Описание" value="{{ old('description', $photo->description) }}" placeholder="Описание (необязательно)" />
            <x-form.error>@error('description'){{ $message }}@enderror</x-form.error>
        </div>
        <div class="mt-4">
            <label for="image" class="block font-bold mb-1">Новое изображение</label>
            @if($photo->image)
                <img src="{{ asset('storage/gallery/' . $photo->image) }}" alt="Текущее изображение" class="w-40 mb-1 rounded shadow">
            @endif
            <input class="border rounded w-full px-3 py-2" type="file" name="image" id="image" accept="image/*">
            <x-form.error>@error('image'){{ $message }}@enderror</x-form.error>
        </div>
        <div class="mt-6">
            <x-form.button>Сохранить</x-form.button>
            <a href="{{ route('gallery.index') }}" class="ml-3 text-blue-600 hover:underline">Назад</a>
        </div>
    </x-form.form>
</div>
@endsection
