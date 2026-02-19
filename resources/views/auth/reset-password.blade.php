@extends('layouts.app')

@section('title', 'Новый пароль')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white/80 rounded-xl p-6 shadow">
        <h1 class="text-2xl font-bold text-blue-950 mb-4">Установить новый пароль</h1>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm font-medium mb-1">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email', request('email')) }}" required class="w-full border rounded-lg px-3 py-2" />
                @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1">Новый пароль</label>
                <input id="password" name="password" type="password" required class="w-full border rounded-lg px-3 py-2" />
                @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium mb-1">Повторите пароль</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full border rounded-lg px-3 py-2" />
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-700">Сохранить пароль</button>
        </form>
    </div>
@endsection
