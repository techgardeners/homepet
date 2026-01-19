<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\BookingServiceType;
use App\Entity\Enum\BookingStatus;
use App\Entity\Trait\SoftDeletableTrait;
use App\Repository\BookingRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Booking entity representing a pet care service reservation.
 */
#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Booking extends BaseEntity
{
    use SoftDeletableTrait;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $host;

    #[ORM\ManyToOne(targetEntity: Pet::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Pet $pet;

    #[ORM\Column(type: 'string', enumType: BookingServiceType::class)]
    private BookingServiceType $serviceType;

    #[ORM\Column(type: 'string', enumType: BookingStatus::class)]
    private BookingStatus $status = BookingStatus::DRAFT;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $startDate;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $endDate;

    /**
     * Total price in cents.
     */
    #[ORM\Column(type: 'integer')]
    private int $priceTotal = 0;

    /**
     * Platform fee in cents.
     */
    #[ORM\Column(type: 'integer')]
    private int $pricePlatformFee = 0;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'booking', orphanRemoval: true)]
    private Collection $reviews;

    /**
     * @var Collection<int, MeetAndGreet>
     */
    #[ORM\OneToMany(targetEntity: MeetAndGreet::class, mappedBy: 'booking', orphanRemoval: true)]
    private Collection $meetAndGreets;

    public function __construct()
    {
        parent::__construct();
        $this->reviews = new ArrayCollection();
        $this->meetAndGreets = new ArrayCollection();
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getHost(): User
    {
        return $this->host;
    }

    public function setHost(User $host): static
    {
        $this->host = $host;

        return $this;
    }

    public function getPet(): Pet
    {
        return $this->pet;
    }

    public function setPet(Pet $pet): static
    {
        $this->pet = $pet;

        return $this;
    }

    public function getServiceType(): BookingServiceType
    {
        return $this->serviceType;
    }

    public function setServiceType(BookingServiceType $serviceType): static
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    public function getStatus(): BookingStatus
    {
        return $this->status;
    }

    public function setStatus(BookingStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get duration in days.
     */
    public function getDurationDays(): int
    {
        return $this->startDate->diff($this->endDate)->days;
    }

    public function getPriceTotal(): int
    {
        return $this->priceTotal;
    }

    public function setPriceTotal(int $priceTotal): static
    {
        $this->priceTotal = $priceTotal;

        return $this;
    }

    /**
     * Get total price as float (euros).
     */
    public function getPriceTotalAsFloat(): float
    {
        return $this->priceTotal / 100;
    }

    public function getPricePlatformFee(): int
    {
        return $this->pricePlatformFee;
    }

    public function setPricePlatformFee(int $pricePlatformFee): static
    {
        $this->pricePlatformFee = $pricePlatformFee;

        return $this;
    }

    /**
     * Get host payout (total - platform fee).
     */
    public function getHostPayout(): int
    {
        return $this->priceTotal - $this->pricePlatformFee;
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

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    /**
     * @return Collection<int, MeetAndGreet>
     */
    public function getMeetAndGreets(): Collection
    {
        return $this->meetAndGreets;
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function isFinal(): bool
    {
        return $this->status->isFinal();
    }

    public function canBeReviewed(): bool
    {
        return $this->status === BookingStatus::COMPLETED;
    }
}
