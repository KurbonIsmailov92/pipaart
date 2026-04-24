@extends('layouts.app')

@section('title', __('ui.contact.title'))

@section('content')
    <x-ui.page-header :title="__('ui.contact.title')" :description="__('ui.contact.description')" :eyebrow="__('ui.nav.contact')">
        <x-slot:actions>
            <x-ui.button-link :href="route('contacts.message')" variant="secondary">{{ __('ui.contact.open_form') }}</x-ui.button-link>
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-1">
            <x-ui.card>
                <p class="ui-kicker">{{ __('ui.contact.direct_contact') }}</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $settings['contact_email'] }}</h2>
                <p class="mt-3 text-sm text-slate-600">{{ __('ui.contact.send_message_description') }}</p>
            </x-ui.card>

            <x-ui.card class="bg-[linear-gradient(135deg,rgba(223,238,246,0.88),rgba(244,239,229,0.96))]">
                <div class="space-y-4 text-sm text-slate-700">
                    <div>
                        <p class="ui-kicker">{{ __('ui.forms.email') }}</p>
                        <p class="mt-2 font-medium text-slate-900">{{ $settings['contact_email'] }}</p>
                    </div>
                    @if(! empty($settings['contact_backup_email']))
                        <div>
                            <p class="ui-kicker">{{ __('ui.contact.backup_email') }}</p>
                            <p class="mt-2 font-medium text-slate-900">{{ $settings['contact_backup_email'] }}</p>
                        </div>
                    @endif
                    @if(! empty($settings['contact_phone']))
                        <div>
                            <p class="ui-kicker">{{ __('ui.forms.phone') }}</p>
                            <p class="mt-2 font-medium text-slate-900">{{ $settings['contact_phone'] }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="ui-kicker">{{ __('ui.nav.contact') }}</p>
                        <p class="mt-2 font-medium text-slate-900">{{ $settings['contact_address'] }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <x-ui.card class="overflow-hidden p-0">
            <div class="grid h-full lg:grid-cols-[0.9fr_1.1fr]">
                <div class="bg-[linear-gradient(160deg,rgba(20,57,80,0.96),rgba(31,95,133,0.82),rgba(215,187,119,0.34))] p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-white/60">{{ __('ui.contact.send_message_title') }}</p>
                    <h2 class="mt-3 text-3xl font-semibold">{{ __('ui.contact.write_to_us') }}</h2>
                    <p class="mt-4 text-sm text-white/[0.78]">{{ __('ui.contact.send_message_description') }}</p>
                    <div class="mt-8">
                        <x-ui.button-link :href="route('contacts.message')" variant="secondary">{{ __('ui.contact.open_form') }}</x-ui.button-link>
                    </div>
                </div>

                <div class="p-8">
                    <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/stock.jpg') }}" alt="{{ __('ui.contact.title') }}" class="h-full min-h-[18rem] w-full rounded-[1.75rem] object-cover">
                </div>
            </div>
        </x-ui.card>
    </div>
@endsection
