@extends('layouts.app')

@section('title', __('ui.contact.message_title'))

@section('content')
    @php
        $currentLocale = request()->route('locale', app()->getLocale());
    @endphp
    <x-ui.page-header :title="__('ui.contact.message_title')" :description="__('ui.contact.message_description')" :eyebrow="__('ui.nav.contact')" />

    <div class="grid gap-6 lg:grid-cols-[0.88fr_1.12fr]">
        <x-ui.card class="bg-[linear-gradient(160deg,rgba(20,57,80,0.96),rgba(31,95,133,0.82),rgba(215,187,119,0.34))] text-white">
            <x-ui.alert class="border-white/20 bg-white/10 text-white">
                {{ __('ui.contact.reply_notice', ['email' => $settings['contact_email']]) }}
            </x-ui.alert>

            <div class="mt-6 space-y-4 text-sm text-white/[0.82]">
                @if(! empty($settings['contact_phone']))
                    <p><span class="font-semibold text-white">{{ __('ui.forms.phone') }}:</span> {{ $settings['contact_phone'] }}</p>
                @endif
                <p><span class="font-semibold text-white">{{ __('ui.forms.email') }}:</span> {{ $settings['contact_email'] }}</p>
                @if(! empty($settings['contact_backup_email']))
                    <p><span class="font-semibold text-white">{{ __('ui.contact.backup_email') }}:</span> {{ $settings['contact_backup_email'] }}</p>
                @endif
                <p><span class="font-semibold text-white">{{ __('ui.nav.contact') }}:</span> {{ $settings['contact_address'] }}</p>
            </div>

            <div class="mt-8 overflow-hidden rounded-[1.75rem]">
                <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/bg.jpg') }}" alt="{{ __('ui.contact.title') }}" class="h-64 w-full object-cover">
            </div>
        </x-ui.card>

        <x-ui.card>
            <form method="POST" action="{{ route('contacts.message.store', ['locale' => $currentLocale]) }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required class="ui-input">
                    @error('name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.email') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="ui-input">
                    @error('email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.phone') }}</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="ui-input">
                    @error('phone')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="message" class="mb-2 block text-sm font-medium text-slate-700">{{ __('ui.forms.message') }}</label>
                    <textarea id="message" name="message" rows="7" required class="ui-input">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <x-form.button>{{ __('ui.contact.write_to_us') }}</x-form.button>
            </form>
        </x-ui.card>
    </div>
@endsection
