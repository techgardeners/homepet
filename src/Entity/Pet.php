<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\PetSpecies;
use App\Entity\Trait\SoftDeletableTrait;
use App\Repository\PetRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pet entity representing an animal owned by a user.
 */
#[ORM\Entity(repositoryClass: PetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Pet extends BaseEntity
{
    use SoftDeletableTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    #[ORM\Column(type: 'string', length: 100)]
    private string $name;

    #[ORM\Column(type: 'string', enumType: PetSpecies::class)]
    private PetSpecies $species;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $breed = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $birthDate = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $weightKg = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVaccinated = false;

    #[ORM\Column(type: 'boolean')]
    private bool $isNeutered = false;

    #[ORM\Column(type: 'boolean')]
    private bool $isHouseTrained = false;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $temperament = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $behaviorNotes = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $routine = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $medicalNotes = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $dietaryRestrictions = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $allergies = null;

    /**
     * Dog-specific attributes (size, barking level, leash behavior, etc.).
     *
     * @var array<string, mixed>|null
     */
    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $dogAttributes = null;

    /**
     * Cat-specific attributes (indoor/outdoor, litter preferences, etc.).
     *
     * @var array<string, mixed>|null
     */
    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $catAttributes = null;

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSpecies(): PetSpecies
    {
        return $this->species;
    }

    public function setSpecies(PetSpecies $species): static
    {
        $this->species = $species;

        return $this;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(?string $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeImmutable $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Calculate approximate age in years.
     */
    public function getAgeYears(): ?int
    {
        if ($this->birthDate === null) {
            return null;
        }

        $now = new DateTimeImmutable('now', new \DateTimeZone('UTC'));

        return $now->diff($this->birthDate)->y;
    }

    public function getWeightKg(): ?float
    {
        return $this->weightKg;
    }

    public function setWeightKg(?float $weightKg): static
    {
        $this->weightKg = $weightKg;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function isVaccinated(): bool
    {
        return $this->isVaccinated;
    }

    public function setIsVaccinated(bool $isVaccinated): static
    {
        $this->isVaccinated = $isVaccinated;

        return $this;
    }

    public function isNeutered(): bool
    {
        return $this->isNeutered;
    }

    public function setIsNeutered(bool $isNeutered): static
    {
        $this->isNeutered = $isNeutered;

        return $this;
    }

    public function isHouseTrained(): bool
    {
        return $this->isHouseTrained;
    }

    public function setIsHouseTrained(bool $isHouseTrained): static
    {
        $this->isHouseTrained = $isHouseTrained;

        return $this;
    }

    public function getTemperament(): ?string
    {
        return $this->temperament;
    }

    public function setTemperament(?string $temperament): static
    {
        $this->temperament = $temperament;

        return $this;
    }

    public function getBehaviorNotes(): ?string
    {
        return $this->behaviorNotes;
    }

    public function setBehaviorNotes(?string $behaviorNotes): static
    {
        $this->behaviorNotes = $behaviorNotes;

        return $this;
    }

    public function getRoutine(): ?string
    {
        return $this->routine;
    }

    public function setRoutine(?string $routine): static
    {
        $this->routine = $routine;

        return $this;
    }

    public function getMedicalNotes(): ?string
    {
        return $this->medicalNotes;
    }

    public function setMedicalNotes(?string $medicalNotes): static
    {
        $this->medicalNotes = $medicalNotes;

        return $this;
    }

    public function getDietaryRestrictions(): ?string
    {
        return $this->dietaryRestrictions;
    }

    public function setDietaryRestrictions(?string $dietaryRestrictions): static
    {
        $this->dietaryRestrictions = $dietaryRestrictions;

        return $this;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(?string $allergies): static
    {
        $this->allergies = $allergies;

        return $this;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getDogAttributes(): ?array
    {
        return $this->dogAttributes;
    }

    /**
     * @param array<string, mixed>|null $dogAttributes
     */
    public function setDogAttributes(?array $dogAttributes): static
    {
        $this->dogAttributes = $dogAttributes;

        return $this;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getCatAttributes(): ?array
    {
        return $this->catAttributes;
    }

    /**
     * @param array<string, mixed>|null $catAttributes
     */
    public function setCatAttributes(?array $catAttributes): static
    {
        $this->catAttributes = $catAttributes;

        return $this;
    }

    public function isDog(): bool
    {
        return $this->species === PetSpecies::DOG;
    }

    public function isCat(): bool
    {
        return $this->species === PetSpecies::CAT;
    }
}
