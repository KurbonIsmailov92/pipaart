<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\NewsPost;
use App\Models\User;

class NewsPostPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, NewsPost $newsPost): bool
    {
        if (($newsPost->published_at === null) || $newsPost->published_at->isPast()) {
            return true;
        }

        return $user?->hasRole([UserRole::Admin, UserRole::Teacher]) ?? false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole([UserRole::Admin, UserRole::Teacher]);
    }

    public function update(User $user, NewsPost $newsPost): bool
    {
        return $user->hasRole([UserRole::Admin, UserRole::Teacher]);
    }

    public function delete(User $user, NewsPost $newsPost): bool
    {
        return $user->hasRole([UserRole::Admin, UserRole::Teacher]);
    }
}
