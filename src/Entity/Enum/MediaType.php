<?php

declare(strict_types=1);

namespace App\Entity\Enum;

/**
 * Types of media files stored in the platform.
 */
enum MediaType: string
{
    case AVATAR = 'avatar';
    case PET_PHOTO = 'pet_photo';
    case HOST_PHOTO = 'host_photo';
    case DOCUMENT = 'document';

    public function label(): string
    {
        return match ($this) {
            self::AVATAR => 'Avatar',
            self::PET_PHOTO => 'Pet Photo',
            self::HOST_PHOTO => 'Host Photo',
            self::DOCUMENT => 'Document',
        };
    }

    public function isImage(): bool
    {
        return in_array($this, [self::AVATAR, self::PET_PHOTO, self::HOST_PHOTO], true);
    }

    public function maxFileSize(): int
    {
        return match ($this) {
            self::AVATAR => 2 * 1024 * 1024,       // 2 MB
            self::PET_PHOTO => 5 * 1024 * 1024,    // 5 MB
            self::HOST_PHOTO => 5 * 1024 * 1024,   // 5 MB
            self::DOCUMENT => 10 * 1024 * 1024,    // 10 MB
        };
    }
}
