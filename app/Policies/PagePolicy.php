<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Page $page): bool
    {
        return $page->is_published || ($user?->hasRole(UserRole::Admin) ?? false);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function update(User $user, Page $page): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->hasRole(UserRole::Admin);
    }
}
