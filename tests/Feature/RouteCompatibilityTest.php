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

it('renders the localized courses list page', function (): void {
    $this->get('/ru/courses/list')->assertOk();
});

it('renders the localized news list page', function (): void {
    $this->get('/ru/news/list')->assertOk();
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

it('renders the auth login page', function (): void {
    $this->get('/auth/login')->assertOk();
});

it('logs in with the seeded admin account', function (): void {
    $this->seed(\Database\Seeders\AdminUserSeeder::class);

    $this->post(route('auth.login.store'), [
        'email' => 'admin@admin.com',
        'password' => 'password1234',
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
