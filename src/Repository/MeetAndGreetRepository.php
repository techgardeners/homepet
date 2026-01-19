<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MeetAndGreet;
use App\Entity\Booking;
use App\Entity\Enum\MeetAndGreetStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MeetAndGreet>
 */
class MeetAndGreetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeetAndGreet::class);
    }

    /**
     * Find meet and greets for a booking.
     *
     * @return MeetAndGreet[]
     */
    public function findByBooking(Booking $booking): array
    {
        return $this->createQueryBuilder('mg')
            ->andWhere('mg.booking = :booking')
            ->setParameter('booking', $booking)
            ->orderBy('mg.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find pending meet and greets.
     *
     * @return MeetAndGreet[]
     */
    public function findPending(): array
    {
        return $this->createQueryBuilder('mg')
            ->andWhere('mg.status IN (:statuses)')
            ->setParameter('statuses', [
                MeetAndGreetStatus::PROPOSED->value,
                MeetAndGreetStatus::SCHEDULED->value,
            ])
            ->orderBy('mg.scheduledAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
