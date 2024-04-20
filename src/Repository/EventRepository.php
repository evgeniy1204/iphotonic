<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return Event[]
     */
    public function findUpcomingEvents(int $limit = 3): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.createdEventStartAt >= :now')
            ->orWhere('e.createdEventEndAt <= :now')
            ->andWhere('e.active = true')
            ->orderBy('e.createdEventStartAt', 'ASC')
            ->setMaxResults($limit)
            ->setParameter('now', new \DateTime('now'))
            ->getQuery()
            ->getResult();
    }
}
