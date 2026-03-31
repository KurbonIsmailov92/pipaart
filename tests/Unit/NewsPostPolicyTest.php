<?php

use App\Models\NewsPost;
use App\Models\User;
use App\Policies\NewsPostPolicy;

it('allows admin to delete news posts', function (): void {
    $policy = new NewsPostPolicy();

    $admin = new User(['role' => User::ROLE_ADMIN]);
    $newsPost = new NewsPost();

    expect($policy->delete($admin, $newsPost))->toBeTrue();
});

it('denies non-admin to delete news posts', function (): void {
    $policy = new NewsPostPolicy();

    $reader = new User(['role' => User::ROLE_READER]);
    $newsPost = new NewsPost();

    expect($policy->delete($reader, $newsPost))->toBeFalse();
});
