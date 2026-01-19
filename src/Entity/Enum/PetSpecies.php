<?php

declare(strict_types=1);

namespace App\Entity\Enum;

/**
 * Pet species supported by the platform.
 */
enum PetSpecies: string
{
    case DOG = 'dog';
    case CAT = 'cat';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::DOG => 'Dog',
            self::CAT => 'Cat',
            self::OTHER => 'Other',
        };
    }

    public function emoji(): string
    {
        return match ($this) {
            self::DOG => '🐕',
            self::CAT => '🐈',
            self::OTHER => '🐾',
        };
    }
}
