<?php

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Support\Facades\Hash;

it('creates or updates the default admin user idempotently', function (): void {
    $this->seed(AdminUserSeeder::class);
    $this->seed(AdminUserSeeder::class);

    $admin = User::query()->where('email', 'admin@admin.com')->first();

    expect($admin)->not->toBeNull()
        ->and(User::query()->where('email', 'admin@admin.com')->count())->toBe(1)
        ->and($admin->role?->value ?? $admin->role)->toBe(UserRole::Admin->value)
        ->and(Hash::check('password1234', (string) $admin->password))->toBeTrue();
});
