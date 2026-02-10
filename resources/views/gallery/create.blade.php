@extends('layouts.app')
@section('title', 'Добавить фото')
@section('content')
<div class="container mx-auto px-4 pt-10 max-w-sm">
    <h1 class="text-xl font-bold mb-5">Добавить фото в галерею</h1>
    <x-form.form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
        <div>
            <x-form.input name="title" label="Название" placeholder="Название фото" />
            <x-form.error>@error('title'){{ $message }}@enderror</x-form.error>
        </div>
        <div class="mt-4">
            <x-form.input name="description" label="Описание" placeholder="Описание (необязательно)" />
            <x-form.error>@error('description'){{ $message }}@enderror</x-form.error>
        </div>
        <div class="mt-4">
            <label for="image" class="block font-bold mb-1">Изображение *</label>
            <input class="border rounded w-full px-3 py-2" type="file" name="image" id="image" accept="image/*" required>
            <x-form.error>@error('image'){{ $message }}@enderror</x-form.error>
        </div>
        <div class="mt-6">
            <x-form.button>Загрузить</x-form.button>
        </div>
    </x-form.form>
</div>
@endsection
