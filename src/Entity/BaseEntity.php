<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\BlameableTrait;
use App\Entity\Trait\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Abstract base entity providing common functionality for all entities.
 *
 * Features:
 * - UUID v7 primary key (time-ordered)
 * - Automatic timestamps (createdAt, updatedAt)
 * - User tracking (createdBy, updatedBy)
 */
#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
abstract class BaseEntity
{
    use TimestampableTrait;
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * Returns the ID as a string for serialization/display purposes.
     */
    public function getIdString(): string
    {
        return $this->id->toRfc4122();
    }
}
