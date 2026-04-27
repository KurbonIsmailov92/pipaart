@extends('layouts.admin')

@section('title', __('ui.admin.certificates'))
@section('page-title', __('ui.admin.certificates'))

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.certificates.create') }}" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ __('ui.admin.create_certificate') }}</a>
    </div>

    <div class="table-shell">
        <table class="data-table">
            <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-3">{{ __('ui.forms.title') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.user') }}</th>
                <th class="px-4 py-3">{{ __('ui.forms.course') }}</th>
                <th class="px-4 py-3">{{ __('ui.cabinet.issued_at') }}</th>
                <th class="px-4 py-3">{{ __('ui.common.status') }}</th>
                <th class="px-4 py-3 text-right">{{ __('ui.common.actions') }}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($certificates as $certificate)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $certificate->title }}</td>
                    <td class="px-4 py-3">{{ $certificate->user?->name }}</td>
                    <td class="px-4 py-3">{{ $certificate->course?->title ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $certificate->issued_at?->format('Y-m-d') ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $certificate->status }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.certificates.edit', $certificate) }}" class="text-blue-600">{{ __('ui.common.edit') }}</a>
                            <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick='return confirm(@js(__('ui.common.confirm_delete')))'>{{ __('ui.common.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500">{{ __('ui.admin.no_certificates') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $certificates->links() }}</div>
@endsection
