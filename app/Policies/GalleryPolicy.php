<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Gallery;
use App\Models\User;

class GalleryPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Gallery $gallery): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function update(User $user, Gallery $gallery): bool
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function delete(User $user, Gallery $gallery): bool
    {
        return $user->hasRole(UserRole::Admin);
    }
}
