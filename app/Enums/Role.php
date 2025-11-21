<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case CLINICIAN = 'clinician';

    /**
     * Get all role values as an array.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the display name for the role.
     */
    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::CLINICIAN => 'Clinician',
        };
    }
}

