<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\Enum\BookingStatus;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * Find bookings for an owner.
     *
     * @return Booking[]
     */
    public function findByOwner(User $owner): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.owner = :owner')
            ->andWhere('b.deletedAt IS NULL')
            ->setParameter('owner', $owner)
            ->orderBy('b.startDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find bookings for a host.
     *
     * @return Booking[]
     */
    public function findByHost(User $host): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.host = :host')
            ->andWhere('b.deletedAt IS NULL')
            ->setParameter('host', $host)
            ->orderBy('b.startDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find active bookings (pending, confirmed, or checked in).
     *
     * @return Booking[]
     */
    public function findActive(): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.deletedAt IS NULL')
            ->andWhere('b.status IN (:statuses)')
            ->setParameter('statuses', [
                BookingStatus::PENDING_HOST_CONFIRMATION->value,
                BookingStatus::CONFIRMED->value,
                BookingStatus::CHECKED_IN->value,
            ])
            ->orderBy('b.startDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find bookings by status.
     *
     * @return Booking[]
     */
    public function findByStatus(BookingStatus $status): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.deletedAt IS NULL')
            ->andWhere('b.status = :status')
            ->setParameter('status', $status)
            ->orderBy('b.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find upcoming bookings for a host.
     *
     * @return Booking[]
     */
    public function findUpcomingForHost(User $host): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.host = :host')
            ->andWhere('b.deletedAt IS NULL')
            ->andWhere('b.status = :status')
            ->andWhere('b.startDate > :now')
            ->setParameter('host', $host)
            ->setParameter('status', BookingStatus::CONFIRMED)
            ->setParameter('now', new \DateTimeImmutable('now', new \DateTimeZone('UTC')))
            ->orderBy('b.startDate', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
