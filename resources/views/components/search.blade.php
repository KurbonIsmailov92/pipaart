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
        class="ui-input"
    >
    <button type="submit" class="ui-button ui-button-primary">
        {{ __('ui.common.search') }}
    </button>
</form>
