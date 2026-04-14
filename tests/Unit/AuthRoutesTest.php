<?php

use Illuminate\Support\Facades\Route;

it('has login and register routes used by views', function (): void {
    expect(Route::has('auth.login'))->toBeTrue()
        ->and(Route::has('auth.register'))->toBeTrue();
});

it('has sign-in and logout aliases', function (): void {
    expect(Route::has('auth.sign-in'))->toBeTrue()
        ->and(Route::has('auth.logout'))->toBeTrue()
        ->and(Route::has('logout'))->toBeTrue();
});
