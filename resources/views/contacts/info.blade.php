@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
    <section class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-semibold mb-4">Контакты</h1>

        <div class="bg-white rounded-lg shadow p-6 space-y-3 text-gray-800">
            <p><strong>Email:</strong> info@pipaa.tj</p>
            <p><strong>Резервный email:</strong> pipaart@mail.ru</p>
            <p><strong>Телефон:</strong> +992 935 60 33 38</p>
            <p>
                Если хотите написать нам прямо с сайта, перейдите на страницу
                <a href="{{ route('contacts.message') }}" class="text-blue-700 underline">«Написать нам»</a>.
            </p>
        </div>
    </section>
@endsection
