<?php

declare(strict_types=1);

namespace App\Entity\Enum;

/**
 * Booking lifecycle statuses.
 */
enum BookingStatus: string
{
    case DRAFT = 'draft';
    case PENDING_HOST_CONFIRMATION = 'pending_host_confirmation';
    case CONFIRMED = 'confirmed';
    case CHECKED_IN = 'checked_in';
    case CHECKED_OUT = 'checked_out';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case DISPUTED = 'disputed';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING_HOST_CONFIRMATION => 'Pending Host Confirmation',
            self::CONFIRMED => 'Confirmed',
            self::CHECKED_IN => 'Checked In',
            self::CHECKED_OUT => 'Checked Out',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
            self::DISPUTED => 'Disputed',
        };
    }

    public function isActive(): bool
    {
        return in_array($this, [
            self::PENDING_HOST_CONFIRMATION,
            self::CONFIRMED,
            self::CHECKED_IN,
        ], true);
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::COMPLETED,
            self::CANCELLED,
        ], true);
    }
}
