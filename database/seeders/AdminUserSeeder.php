<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = trim((string) config('admin.email', ''));
        $name = trim((string) config('admin.name', ''));
        $password = (string) config('admin.password', '');

        $email = $email !== '' ? $email : 'admin@pipaa.tj';
        $name = $name !== '' ? $name : 'PIPAA Admin';
        $password = $password !== '' ? $password : 'Mirzoal!ev123';

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => UserRole::Admin->value,
            ],
        );

        $user->forceFill([
            'email_verified_at' => $user->email_verified_at ?? now(),
            'role' => UserRole::Admin->value,
        ])->save();
    }
}
