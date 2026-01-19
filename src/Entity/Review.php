<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Review entity for booking feedback.
 */
#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Review extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: Booking::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private Booking $booking;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $subject;

    #[ORM\Column(type: 'smallint')]
    private int $rating;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comment = null;

    public function getBooking(): Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): static
    {
        $this->booking = $booking;

        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getSubject(): User
    {
        return $this->subject;
    }

    public function setSubject(User $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException('Rating must be between 1 and 5');
        }

        $this->rating = $rating;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Check if review is from owner to host.
     */
    public function isOwnerToHost(): bool
    {
        return $this->author->getId()->equals($this->booking->getOwner()->getId());
    }

    /**
     * Check if review is from host to owner.
     */
    public function isHostToOwner(): bool
    {
        return $this->author->getId()->equals($this->booking->getHost()->getId());
    }
}
