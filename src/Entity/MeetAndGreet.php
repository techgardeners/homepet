<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\MeetAndGreetStatus;
use App\Repository\MeetAndGreetRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * MeetAndGreet entity for pre-booking compatibility meetings.
 */
#[ORM\Entity(repositoryClass: MeetAndGreetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class MeetAndGreet extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: Booking::class, inversedBy: 'meetAndGreets')]
    #[ORM\JoinColumn(nullable: false)]
    private Booking $booking;

    #[ORM\Column(type: 'string', enumType: MeetAndGreetStatus::class)]
    private MeetAndGreetStatus $status = MeetAndGreetStatus::PROPOSED;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $scheduledAt = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVideo = false;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    public function getBooking(): Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): static
    {
        $this->booking = $booking;

        return $this;
    }

    public function getStatus(): MeetAndGreetStatus
    {
        return $this->status;
    }

    public function setStatus(MeetAndGreetStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getScheduledAt(): ?DateTimeImmutable
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(?DateTimeImmutable $scheduledAt): static
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function isVideo(): bool
    {
        return $this->isVideo;
    }

    public function setIsVideo(bool $isVideo): static
    {
        $this->isVideo = $isVideo;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function isPending(): bool
    {
        return $this->status->isPending();
    }

    public function isCompleted(): bool
    {
        return $this->status === MeetAndGreetStatus::DONE;
    }

    public function markAsScheduled(DateTimeImmutable $at): static
    {
        $this->status = MeetAndGreetStatus::SCHEDULED;
        $this->scheduledAt = $at;

        return $this;
    }

    public function markAsDone(): static
    {
        $this->status = MeetAndGreetStatus::DONE;

        return $this;
    }

    public function markAsNotSuitable(?string $reason = null): static
    {
        $this->status = MeetAndGreetStatus::NOT_SUITABLE;
        if ($reason !== null) {
            $this->notes = $reason;
        }

        return $this;
    }
}
