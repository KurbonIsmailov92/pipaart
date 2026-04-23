@if(session('success'))
    <div class="shell-container mt-6">
        <x-ui.alert variant="success">
            {{ session('success') }}
        </x-ui.alert>
    </div>
@endif
