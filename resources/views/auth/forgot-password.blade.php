@extends('layouts.app')

@section('title', 'Восстановление пароля')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white/80 rounded-xl p-6 shadow">
        <h1 class="text-2xl font-bold text-blue-950 mb-3">Восстановление пароля</h1>
        <p class="text-sm text-gray-700 mb-4">Введите email, на который будет отправлена ссылка для сброса пароля.</p>

        @if (session('message'))
            <p class="mb-3 text-sm text-green-700">{{ session('message') }}</p>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium mb-1">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full border rounded-lg px-3 py-2" />
                @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-700">Отправить ссылку</button>
        </form>

        <div class="mt-4 text-sm">
            <a href="{{ route('auth.login') }}" class="text-blue-700 hover:underline">Вернуться ко входу</a>
        </div>
    </div>
@endsection
