<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    public function view(User $user, Course $course)
    {
        return true; // Everyone can view
    }

    public function create(User $user)
    {
        return $user->is_admin;
    }

    public function update(User $user, Course $course)
    {
        return $user->is_admin;
    }

    public function delete(User $user, Course $course)
    {
        return $user->is_admin;
    }
}
