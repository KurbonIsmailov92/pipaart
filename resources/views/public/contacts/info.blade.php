@extends('layouts.app')

@section('title', 'Contacts')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-8">
        <h1 class="mb-4 text-2xl font-semibold">Contacts</h1>

        <div class="space-y-3 rounded-lg bg-white p-6 text-gray-800 shadow">
            <p><strong>Email:</strong> {{ $settings['contact_email'] }}</p>
            <p><strong>Backup email:</strong> {{ $settings['contact_backup_email'] }}</p>
            <p><strong>Phone:</strong> {{ $settings['contact_phone'] }}</p>
            <p><strong>Address:</strong> {{ $settings['contact_address'] }}</p>
            <p>
                If you want to contact us directly from the website, visit
                <a href="{{ route('contacts.message') }}" class="text-blue-700 underline">the message page</a>.
            </p>
        </div>
    </section>
@endsection
