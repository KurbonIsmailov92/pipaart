@props([
    'action' => route('search'),
    'name' => 'q',
    'placeholder' => 'Search...',
    'value' => null,
])

<form method="GET" action="{{ $action }}" class="surface-card flex flex-col gap-3 p-4 sm:flex-row sm:items-center">
    <input
        type="text"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
    >
    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-medium text-white hover:bg-blue-900">
        Search
    </button>
</form>
