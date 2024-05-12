<?php

namespace App\Repository;

use App\Entity\Event;
use App\Service\Pagination;
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
	public function findUpcomingEvents(int $limit = 10): array
	{
		return $this->createQueryBuilder('e')
			->andWhere('e.active = TRUE')
			->orderBy('e.createdEventStartAt', 'ASC')
			->setMaxResults($limit)
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

	/**
	 * @param Pagination $pagination
	 * @return Event[]
	 */
	public function buildPaginationArticles(Pagination $pagination): array
	{
		$qb = $this->createQueryBuilder('Event');

		$qb
			->select('Event')
			->andWhere('Event.active = TRUE')
			->setMaxResults($pagination->getPerPage())
			->setFirstResult($pagination->calculateOffset());

		return $qb->getQuery()->getResult();
	}

	public function findAllActiveCount(): int
	{
		$qb = $this->createQueryBuilder('Event');

		$qb
			->select('COUNT(1)')
			->andWhere('Event.active = TRUE');

		return $qb->getQuery()->getSingleScalarResult();
	}
}
