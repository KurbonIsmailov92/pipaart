@extends('layouts.app')

@section('title', 'Вход')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white/80 rounded-xl p-6 shadow">
        <h1 class="text-2xl font-bold text-blue-950 mb-4">Вход в аккаунт</h1>

        @if (session('message'))
            <p class="mb-3 text-sm text-green-700">{{ session('message') }}</p>
        @endif

        <form method="POST" action="{{ route('auth.sign-in') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium mb-1">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full border rounded-lg px-3 py-2" />
                @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1">Пароль</label>
                <input id="password" name="password" type="password" required class="w-full border rounded-lg px-3 py-2" />
                @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-700">Войти</button>
        </form>

        <div class="mt-4 flex justify-between text-sm">
            <a href="{{ route('password.request') }}" class="text-blue-700 hover:underline">Забыли пароль?</a>
            <a href="{{ route('auth.sign-up') }}" class="text-blue-700 hover:underline">Регистрация</a>
        </div>
    </div>
@endsection
