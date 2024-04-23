<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

	/**
	 * @param string $searchText
	 * @return \Generator<Event>
	 */
	public function search(string $searchText): \Generator
	{
		$qb = $this->createQueryBuilder('Event');

		$qb
			->select('Event')
			->andWhere($qb->expr()->orX(
				$qb->expr()->andX('Event.title LIKE :searchText'),
				$qb->expr()->andX('Event.summary LIKE :searchText'),
				$qb->expr()->andX('Event.text LIKE :searchText'),
			))
			->andWhere('Event.active = TRUE')
			->setParameter('searchText', '%' . $searchText . '%');

		yield from $qb->getQuery()->toIterable();
	}
}
