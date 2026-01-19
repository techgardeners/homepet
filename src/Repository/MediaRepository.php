<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Media;
use App\Entity\Enum\MediaType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Media>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    /**
     * Find media for a specific entity.
     *
     * @return Media[]
     */
    public function findByEntity(string $entityType, Uuid $entityId): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.entityType = :entityType')
            ->andWhere('m.entityId = :entityId')
            ->setParameter('entityType', $entityType)
            ->setParameter('entityId', $entityId)
            ->orderBy('m.sortOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find primary media for an entity.
     */
    public function findPrimaryForEntity(string $entityType, Uuid $entityId): ?Media
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.entityType = :entityType')
            ->andWhere('m.entityId = :entityId')
            ->andWhere('m.isPrimary = :primary')
            ->setParameter('entityType', $entityType)
            ->setParameter('entityId', $entityId)
            ->setParameter('primary', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find media by type.
     *
     * @return Media[]
     */
    public function findByType(MediaType $type): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.type = :type')
            ->setParameter('type', $type)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
