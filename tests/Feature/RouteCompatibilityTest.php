<?php

use App\Models\User;

it('redirects the root URL to the default locale', function (): void {
    $this->get('/')
        ->assertRedirect('/ru');
});

it('renders the localized home page', function (): void {
    $this->get('/ru')->assertOk();
});

it('renders the localized courses page', function (): void {
    $this->get('/ru/courses')->assertOk();
});

it('renders the localized news page', function (): void {
    $this->get('/ru/news')->assertOk();
});

it('renders the localized gallery page', function (): void {
    $this->get('/ru/gallery')->assertOk();
});

it('renders the localized oipba gallery page', function (): void {
    $this->get('/ru/oipba/gallery')->assertOk();
});

it('renders the localized legacy list pages used by the public navigation', function (): void {
    $this->get('/ru/news/list')->assertOk();
    $this->get('/ru/courses/list')->assertOk();
});

it('renders the auth login page', function (): void {
    $this->get('/auth/login')->assertOk();
});

it('keeps the logout route alias used by the views', function (): void {
    expect(route('auth.logout', absolute: false))->toBe('/auth/logout');
    expect(route('logout', absolute: false))->toBe('/logout');
});

it('logs in with the seeded admin account', function (): void {
    config([
        'admin.email' => 'admin@pipaa.tj',
        'admin.name' => 'PIPAA Admin',
        'admin.password' => 'Mirzoal!ev123',
    ]);

    $this->seed(\Database\Seeders\AdminUserSeeder::class);

    $this->post(route('auth.login.store'), [
        'email' => 'admin@pipaa.tj',
        'password' => 'Mirzoal!ev123',
    ])->assertRedirect(route('home', ['locale' => 'ru']));
});

it('redirects guests away from admin routes', function (): void {
    $this->get('/admin')
        ->assertRedirect(route('auth.login'));
});

it('allows an authenticated admin to access the admin dashboard', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk();
});
