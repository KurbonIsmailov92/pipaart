<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function update(User $user, User $target): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function delete(User $user, User $target): bool
    {
        return $user->hasRole(UserRole::Admin) && ! $user->is($target);
    }
}
