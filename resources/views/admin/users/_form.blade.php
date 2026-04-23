@csrf

<div class="grid gap-6">
    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $userModel->name) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $userModel->email) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="role" class="mb-2 block text-sm font-medium text-slate-700">Role</label>
        <select id="role" name="role" class="w-full rounded-xl border border-slate-300 px-4 py-3" required>
            @foreach($roles as $role)
                <option value="{{ $role->value }}" @selected(old('role', $userModel->role?->value) === $role->value)>{{ $role->label() }}</option>
            @endforeach
        </select>
        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
            <input id="password" name="password" type="password" class="w-full rounded-xl border border-slate-300 px-4 py-3" @if(! $userModel->exists) required @endif>
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-xl border border-slate-300 px-4 py-3" @if(! $userModel->exists) required @endif>
        </div>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-xl bg-slate-950 px-4 py-3 text-white">{{ $submitLabel }}</button>
    <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 px-4 py-3 text-slate-700">Cancel</a>
</div>
