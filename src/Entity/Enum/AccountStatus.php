<?php

declare(strict_types=1);

namespace App\Entity\Enum;

/**
 * User account enforcement statuses.
 */
enum AccountStatus: string
{
    case ACTIVE = 'active';
    case WARNED = 'warned';
    case SHADOW_BANNED = 'shadow_banned';
    case SUSPENDED = 'suspended';
    case BANNED = 'banned';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::WARNED => 'Warned',
            self::SHADOW_BANNED => 'Shadow Banned',
            self::SUSPENDED => 'Suspended',
            self::BANNED => 'Banned',
        };
    }

    public function canLogin(): bool
    {
        return in_array($this, [self::ACTIVE, self::WARNED, self::SHADOW_BANNED], true);
    }

    public function canInteract(): bool
    {
        return in_array($this, [self::ACTIVE, self::WARNED], true);
    }
}
