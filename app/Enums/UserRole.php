<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Teacher = 'teacher';
    case Student = 'student';
    case Reader = 'reader';
    case Guest = 'guest';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(
            static fn (self $role): string => $role->value,
            self::cases(),
        );
    }

    /**
     * @return list<string>
     */
    public static function assignableValues(): array
    {
        return [
            self::Admin->value,
            self::Teacher->value,
            self::Student->value,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Teacher => 'Teacher',
            self::Student, self::Reader => 'Student',
            self::Guest => 'Guest',
        };
    }
}
