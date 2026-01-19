<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Review;
use App\Entity\Booking;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    /**
     * Find reviews for a booking.
     *
     * @return Review[]
     */
    public function findByBooking(Booking $booking): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.booking = :booking')
            ->setParameter('booking', $booking)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find reviews about a user (as subject).
     *
     * @return Review[]
     */
    public function findBySubject(User $user): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.subject = :user')
            ->setParameter('user', $user)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get average rating for a user.
     */
    public function getAverageRatingForUser(User $user): ?float
    {
        $result = $this->createQueryBuilder('r')
            ->select('AVG(r.rating) as avgRating')
            ->andWhere('r.subject = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== null ? (float) $result : null;
    }

    /**
     * Count reviews for a user.
     */
    public function countForUser(User $user): int
    {
        return (int) $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->andWhere('r.subject = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
