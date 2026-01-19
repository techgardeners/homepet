<?php

declare(strict_types=1);

namespace App\Entity\Enum;

/**
 * Meet and greet session statuses.
 */
enum MeetAndGreetStatus: string
{
    case PROPOSED = 'proposed';
    case SCHEDULED = 'scheduled';
    case DONE = 'done';
    case NOT_SUITABLE = 'not_suitable';

    public function label(): string
    {
        return match ($this) {
            self::PROPOSED => 'Proposed',
            self::SCHEDULED => 'Scheduled',
            self::DONE => 'Completed',
            self::NOT_SUITABLE => 'Not Suitable',
        };
    }

    public function isPending(): bool
    {
        return in_array($this, [self::PROPOSED, self::SCHEDULED], true);
    }
}
