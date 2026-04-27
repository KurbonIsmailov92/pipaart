@extends('layouts.admin')

@section('title', __('ui.admin.contact_messages'))
@section('page-title', __('ui.admin.contact_messages'))

@section('content')
    <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="mb-6 flex flex-col gap-3 sm:flex-row">
        <input
            type="search"
            name="search"
            value="{{ $search }}"
            placeholder="{{ __('ui.common.search') }}"
            class="ui-input"
        >
        <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ __('ui.common.search') }}</button>
    </form>

    <div class="table-shell">
        <table class="data-table">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">{{ __('ui.common.updated') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.name') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.email') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.phone') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.subject') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.message') }}</th>
                <th class="px-4 py-3">{{ __('ui.common.status') }}</th>
                <th class="px-4 py-3 text-right">{{ __('ui.common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($messages as $message)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $message->created_at?->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-3 font-medium">{{ $message->name }}</td>
                    <td class="px-4 py-3">{{ $message->email }}</td>
                    <td class="px-4 py-3">{{ $message->phone ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $message->subject ?: '-' }}</td>
                    <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($message->message, 80) }}</td>
                    <td class="px-4 py-3">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $message->is_read ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $message->is_read ? __('ui.common.read') : __('ui.common.unread') }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.contact-messages.show', $message) }}" class="text-blue-600">{{ __('ui.common.view') }}</a>
                            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick='return confirm(@js(__('ui.common.confirm_delete')))'>{{ __('ui.common.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-slate-500">{{ __('ui.admin.no_contact_messages') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $messages->links() }}</div>
@endsection
