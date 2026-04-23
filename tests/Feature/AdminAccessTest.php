<?php

use App\Models\User;

it('redirects guests away from the admin panel', function (): void {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('auth.login'));
});

it('allows admins into the admin panel', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk();
});

it('blocks students from the admin panel', function (): void {
    $student = User::factory()->student()->create();

    $this->actingAs($student)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});
