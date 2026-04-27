@extends('layouts.admin')

@section('title', __('ui.admin.contact_messages'))
@section('page-title', __('ui.admin.contact_message_details'))

@section('content')
    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.contact-messages.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">{{ __('ui.common.back') }}</a>

        @if($message->is_read)
            <form method="POST" action="{{ route('admin.contact-messages.unread', $message) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-xl bg-amber-600 px-4 py-3 text-white">{{ __('ui.common.mark_unread') }}</button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.contact-messages.read', $message) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-xl bg-emerald-700 px-4 py-3 text-white">{{ __('ui.common.mark_read') }}</button>
            </form>
        @endif

        <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-xl bg-red-600 px-4 py-3 text-white" onclick='return confirm(@js(__('ui.common.confirm_delete')))'>{{ __('ui.common.delete') }}</button>
        </form>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
        <x-ui.card>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.forms.name') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $message->name }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.forms.email') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $message->email }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.forms.phone') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $message->phone ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.forms.subject') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $message->subject ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.common.status') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $message->is_read ? __('ui.common.read') : __('ui.common.unread') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.common.updated') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $message->created_at?->format('Y-m-d H:i') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.common.language') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $message->locale ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.common.ip_address') }}</dt>
                    <dd class="mt-1 text-slate-900">{{ $message->ip_address ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-500">{{ __('ui.common.user_agent') }}</dt>
                    <dd class="mt-1 break-words text-slate-900">{{ $message->user_agent ?: '-' }}</dd>
                </div>
            </dl>
        </x-ui.card>

        <x-ui.card>
            <h2 class="text-xl font-semibold text-slate-950">{{ __('ui.forms.message') }}</h2>
            <div class="mt-4 whitespace-pre-line text-slate-700">{{ $message->message }}</div>
        </x-ui.card>
    </div>
@endsection
