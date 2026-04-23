@extends('layouts.app')

@section('title', 'Contacts')

@section('content')
    <x-ui.page-header title="Contact" description="Reach the institute directly or use the contact form for a queued reply.">
        <x-slot:actions>
            <x-ui.button-link :href="route('contacts.message')" variant="secondary">Open Contact Form</x-ui.button-link>
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-2">
        <x-ui.card>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Direct Contact</p>
            <div class="mt-4 space-y-3 text-slate-700">
                <p><strong>Email:</strong> {{ $settings['contact_email'] }}</p>
                <p><strong>Backup email:</strong> {{ $settings['contact_backup_email'] }}</p>
                <p><strong>Phone:</strong> {{ $settings['contact_phone'] }}</p>
                <p><strong>Address:</strong> {{ $settings['contact_address'] }}</p>
            </div>
        </x-ui.card>

        <x-ui.card>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Send a Message</p>
            <p class="mt-4 text-slate-600">The contact form stores the message in the CMS and dispatches delivery through the queue.</p>
            <div class="mt-6">
                <x-ui.button-link :href="route('contacts.message')">Write to Us</x-ui.button-link>
            </div>
        </x-ui.card>
    </div>
@endsection
