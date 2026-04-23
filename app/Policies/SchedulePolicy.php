<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Schedule;
use App\Models\User;

class SchedulePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Schedule $schedule): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole([UserRole::Admin, UserRole::Teacher]);
    }

    public function update(User $user, Schedule $schedule): bool
    {
        return $user->hasRole([UserRole::Admin, UserRole::Teacher]);
    }

    public function delete(User $user, Schedule $schedule): bool
    {
        return $user->hasRole([UserRole::Admin, UserRole::Teacher]);
    }
}
