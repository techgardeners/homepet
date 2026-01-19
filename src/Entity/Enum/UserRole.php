<?php

declare(strict_types=1);

namespace App\Entity\Enum;

/**
 * User roles in the platform.
 */
enum UserRole: string
{
    case OWNER = 'owner';
    case HOST = 'host';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::OWNER => 'Pet Owner',
            self::HOST => 'Pet Host',
            self::ADMIN => 'Administrator',
        };
    }
}
