<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function scopeByRole(Builder $query, UserRole $role): Builder
    {
        if ($role === UserRole::Student) {
            return $query->whereIn('role', [UserRole::Student->value, UserRole::Reader->value]);
        }

        return $query->where('role', $role->value);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::Admin);
    }

    public function isTeacher(): bool
    {
        return $this->hasRole(UserRole::Teacher);
    }

    public function isStudent(): bool
    {
        return $this->hasRole(UserRole::Student);
    }

    /**
     * @param  string|UserRole|array<int, string|UserRole>  $roles
     */
    public function hasRole(string|UserRole|array $roles): bool
    {
        $roles = is_array($roles) ? $roles : [$roles];

        $values = array_map(
            static fn (string|UserRole $role): string => $role instanceof UserRole ? $role->value : $role,
            $roles,
        );

        $currentRole = $this->role instanceof UserRole
            ? $this->role
            : UserRole::tryFrom((string) $this->getAttribute('role'));

        $currentValue = $currentRole?->value ?? (string) $this->getAttribute('role');

        foreach ($values as $value) {
            $acceptedValues = $value === UserRole::Student->value
                ? [UserRole::Student->value, UserRole::Reader->value]
                : [$value];

            if (in_array($currentValue, $acceptedValues, true)) {
                return true;
            }
        }

        return false;
    }
}
