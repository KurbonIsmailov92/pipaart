<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('registers a new user as student and redirects to localized cabinet', function (): void {
    $response = $this
        ->withSession(['locale' => 'ru'])
        ->post(route('auth.register.store'), [
            'name' => '  Student User  ',
            'email' => 'STUDENT@EXAMPLE.COM',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

    $response->assertRedirect(route('cabinet.index', ['locale' => 'ru']));

    $user = User::query()->where('email', 'student@example.com')->firstOrFail();

    expect($user->name)->toBe('Student User')
        ->and($user->role?->value)->toBe(UserRole::Student->value)
        ->and(Hash::check('password', $user->password))->toBeTrue();

    $this->assertAuthenticatedAs($user);
});

it('keeps admin login working after registration hardening', function (): void {
    $admin = User::factory()->admin()->create([
        'email' => 'admin-login@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->post(route('auth.login.store'), [
        'email' => 'admin-login@example.com',
        'password' => 'password',
    ])->assertRedirect(route('home', ['locale' => 'ru']));

    $this->assertAuthenticatedAs($admin);
});
