@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-8">
        <h1 class="mb-6 text-2xl font-semibold">Contact Us</h1>

        <div class="mb-6 rounded-lg bg-blue-50 p-4 text-sm text-blue-900">
            Replies are sent to {{ $settings['contact_email'] }}.
        </div>

        <form method="POST" action="{{ route('contacts.message.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="mb-1 block text-sm font-medium">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-lg border px-3 py-2"/>
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border px-3 py-2"/>
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="phone" class="mb-1 block text-sm font-medium">Phone</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="w-full rounded-lg border px-3 py-2"/>
                @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="message" class="mb-1 block text-sm font-medium">Message</label>
                <textarea id="message" name="message" rows="6" required class="w-full rounded-lg border px-3 py-2">{{ old('message') }}</textarea>
                @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="rounded-lg bg-blue-700 px-4 py-2 text-white hover:bg-blue-800">
                Send message
            </button>
        </form>
    </section>
@endsection
