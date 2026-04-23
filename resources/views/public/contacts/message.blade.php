@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <x-ui.page-header title="Contact Us" description="We store your message safely and process delivery through the queue."></x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-[0.85fr_1.15fr]">
        <x-ui.card>
            <x-ui.alert>
                Replies are sent to {{ $settings['contact_email'] }}.
            </x-ui.alert>

            <div class="mt-6 space-y-3 text-sm text-slate-600">
                <p><strong>Phone:</strong> {{ $settings['contact_phone'] }}</p>
                <p><strong>Address:</strong> {{ $settings['contact_address'] }}</p>
                <p><strong>Backup email:</strong> {{ $settings['contact_backup_email'] }}</p>
            </div>
        </x-ui.card>

        <x-ui.card>
            <form method="POST" action="{{ route('contacts.message.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    @error('email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    @error('phone')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="message" class="mb-2 block text-sm font-medium text-slate-700">Message</label>
                    <textarea id="message" name="message" rows="7" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <x-form.button>Send Message</x-form.button>
            </form>
        </x-ui.card>
    </div>
@endsection
