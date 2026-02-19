@extends('layouts.app')

@section('title', 'Написать нам')

@section('content')
    <section class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-semibold mb-6">Написать нам</h1>

        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contacts.message.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium mb-1">Имя</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                       class="w-full border rounded-lg px-3 py-2"/>
                @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                       class="w-full border rounded-lg px-3 py-2"/>
                @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium mb-1">Телефон (необязательно)</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                       class="w-full border rounded-lg px-3 py-2"/>
                @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium mb-1">Сообщение</label>
                <textarea id="message" name="message" rows="6" required
                          class="w-full border rounded-lg px-3 py-2">{{ old('message') }}</textarea>
                @error('message')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white rounded-lg px-4 py-2">
                Отправить
            </button>
        </form>
    </section>
@endsection
