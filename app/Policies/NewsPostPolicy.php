<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NewsPost;

class NewsPostPolicy
{
    public function view(User $user, NewsPost $newsPost)
    {
        return true;
    }
    public function create(User $user)
    {
        return $user->is_admin;
    }
    public function update(User $user, NewsPost $newsPost)
    {
        return $user->is_admin;
    }
    public function delete(User $user, NewsPost $newsPost)
    {
        return $user->is_admin;
    }
}
