<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Embeddable\Address;
use App\Entity\Enum\BookingServiceType;
use App\Entity\Enum\PetSpecies;
use App\Entity\Trait\SoftDeletableTrait;
use App\Repository\HostProfileRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Host profile entity containing host-specific information.
 */
#[ORM\Entity(repositoryClass: HostProfileRepository::class)]
#[ORM\HasLifecycleCallbacks]
class HostProfile extends BaseEntity
{
    use SoftDeletableTrait;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'hostProfile')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bio = null;

    #[ORM\Embedded(class: Address::class)]
    private Address $address;

    /**
     * @var list<string>
     */
    #[ORM\Column(type: 'json')]
    private array $acceptedSpecies = [];

    /**
     * @var list<string>
     */
    #[ORM\Column(type: 'json')]
    private array $servicesOffered = [];

    #[ORM\Column(type: 'boolean')]
    private bool $hasGarden = false;

    #[ORM\Column(type: 'boolean')]
    private bool $hasChildren = false;

    #[ORM\Column(type: 'boolean')]
    private bool $hasOtherPets = false;

    #[ORM\Column(type: 'integer')]
    private int $maxPetsAtOnce = 1;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $verifiedAt = null;

    public function __construct()
    {
        parent::__construct();
        $this->address = new Address();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return list<PetSpecies>
     */
    public function getAcceptedSpecies(): array
    {
        return array_filter(
            array_map(fn(string $s) => PetSpecies::tryFrom($s), $this->acceptedSpecies),
            fn(?PetSpecies $s) => $s !== null
        );
    }

    /**
     * @param list<PetSpecies> $species
     */
    public function setAcceptedSpecies(array $species): static
    {
        $this->acceptedSpecies = array_map(fn(PetSpecies $s) => $s->value, $species);

        return $this;
    }

    public function acceptsSpecies(PetSpecies $species): bool
    {
        return in_array($species->value, $this->acceptedSpecies, true);
    }

    /**
     * @return list<BookingServiceType>
     */
    public function getServicesOffered(): array
    {
        return array_filter(
            array_map(fn(string $s) => BookingServiceType::tryFrom($s), $this->servicesOffered),
            fn(?BookingServiceType $s) => $s !== null
        );
    }

    /**
     * @param list<BookingServiceType> $services
     */
    public function setServicesOffered(array $services): static
    {
        $this->servicesOffered = array_map(fn(BookingServiceType $s) => $s->value, $services);

        return $this;
    }

    public function offersService(BookingServiceType $service): bool
    {
        return in_array($service->value, $this->servicesOffered, true);
    }

    public function hasGarden(): bool
    {
        return $this->hasGarden;
    }

    public function setHasGarden(bool $hasGarden): static
    {
        $this->hasGarden = $hasGarden;

        return $this;
    }

    public function hasChildren(): bool
    {
        return $this->hasChildren;
    }

    public function setHasChildren(bool $hasChildren): static
    {
        $this->hasChildren = $hasChildren;

        return $this;
    }

    public function hasOtherPets(): bool
    {
        return $this->hasOtherPets;
    }

    public function setHasOtherPets(bool $hasOtherPets): static
    {
        $this->hasOtherPets = $hasOtherPets;

        return $this;
    }

    public function getMaxPetsAtOnce(): int
    {
        return $this->maxPetsAtOnce;
    }

    public function setMaxPetsAtOnce(int $maxPetsAtOnce): static
    {
        $this->maxPetsAtOnce = max(1, $maxPetsAtOnce);

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getVerifiedAt(): ?DateTimeImmutable
    {
        return $this->verifiedAt;
    }

    public function setVerifiedAt(?DateTimeImmutable $verifiedAt): static
    {
        $this->verifiedAt = $verifiedAt;

        return $this;
    }

    public function verify(): static
    {
        $this->isVerified = true;
        $this->verifiedAt = new DateTimeImmutable('now', new \DateTimeZone('UTC'));

        return $this;
    }
}
