<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HostProfile;
use App\Entity\Enum\BookingServiceType;
use App\Entity\Enum\PetSpecies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HostProfile>
 */
class HostProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HostProfile::class);
    }

    /**
     * Find verified host profiles.
     *
     * @return HostProfile[]
     */
    public function findVerified(): array
    {
        return $this->createQueryBuilder('hp')
            ->andWhere('hp.isVerified = :verified')
            ->andWhere('hp.deletedAt IS NULL')
            ->setParameter('verified', true)
            ->orderBy('hp.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find hosts by location (basic distance calculation).
     *
     * @return HostProfile[]
     */
    public function findNearby(float $latitude, float $longitude, float $radiusKm = 50): array
    {
        // Haversine formula for distance calculation
        $sql = <<<SQL
            SELECT hp 
            FROM App\Entity\HostProfile hp
            WHERE hp.deletedAt IS NULL
            AND hp.isVerified = true
            AND hp.address.latitude IS NOT NULL
            AND hp.address.longitude IS NOT NULL
            AND (
                6371 * acos(
                    cos(radians(:lat)) * cos(radians(hp.address.latitude)) * 
                    cos(radians(hp.address.longitude) - radians(:lng)) + 
                    sin(radians(:lat)) * sin(radians(hp.address.latitude))
                )
            ) <= :radius
            ORDER BY hp.createdAt DESC
        SQL;

        return $this->getEntityManager()
            ->createQuery($sql)
            ->setParameter('lat', $latitude)
            ->setParameter('lng', $longitude)
            ->setParameter('radius', $radiusKm)
            ->getResult();
    }

    /**
     * Find hosts that accept a specific species.
     *
     * @return HostProfile[]
     */
    public function findByAcceptedSpecies(PetSpecies $species): array
    {
        return $this->createQueryBuilder('hp')
            ->andWhere('hp.deletedAt IS NULL')
            ->andWhere('hp.isVerified = :verified')
            ->andWhere('JSON_CONTAINS(hp.acceptedSpecies, :species) = 1')
            ->setParameter('verified', true)
            ->setParameter('species', json_encode($species->value))
            ->getQuery()
            ->getResult();
    }

    /**
     * Find hosts that offer a specific service.
     *
     * @return HostProfile[]
     */
    public function findByService(BookingServiceType $service): array
    {
        return $this->createQueryBuilder('hp')
            ->andWhere('hp.deletedAt IS NULL')
            ->andWhere('hp.isVerified = :verified')
            ->andWhere('JSON_CONTAINS(hp.servicesOffered, :service) = 1')
            ->setParameter('verified', true)
            ->setParameter('service', json_encode($service->value))
            ->getQuery()
            ->getResult();
    }
}
