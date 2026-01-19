<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Provides soft delete functionality.
 *
 * Entities using this trait are not physically deleted but marked with a deletedAt timestamp.
 * Query filters should be configured to exclude soft-deleted entities by default.
 */
trait SoftDeletableTrait
{
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $deletedAt = null;

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    public function delete(): static
    {
        $this->deletedAt = new DateTimeImmutable('now', new \DateTimeZone('UTC'));

        return $this;
    }

    public function restore(): static
    {
        $this->deletedAt = null;

        return $this;
    }
}
