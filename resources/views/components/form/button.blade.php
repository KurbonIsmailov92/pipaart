<button
    type="submit"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400']) }}
>
    {{ $slot }}
</button>
