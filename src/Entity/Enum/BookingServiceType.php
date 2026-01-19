<?php

declare(strict_types=1);

namespace App\Entity\Enum;

/**
 * Types of pet care services offered.
 */
enum BookingServiceType: string
{
    case BOARDING = 'boarding';
    case DAY_CARE = 'day_care';
    case HOUSE_SITTING = 'house_sitting';
    case WALKING = 'walking';
    case DROP_IN_VISIT = 'drop_in_visit';

    public function label(): string
    {
        return match ($this) {
            self::BOARDING => 'Boarding',
            self::DAY_CARE => 'Day Care',
            self::HOUSE_SITTING => 'House Sitting',
            self::WALKING => 'Walking',
            self::DROP_IN_VISIT => 'Drop-in Visit',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::BOARDING => 'Overnight stay at the host\'s home',
            self::DAY_CARE => 'Daytime care at the host\'s home',
            self::HOUSE_SITTING => 'Host stays at your home',
            self::WALKING => 'Dog walking service',
            self::DROP_IN_VISIT => 'Brief home visit for feeding/play',
        };
    }

    public function isOvernight(): bool
    {
        return $this === self::BOARDING || $this === self::HOUSE_SITTING;
    }
}
