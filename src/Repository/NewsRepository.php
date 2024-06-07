<?php

namespace App\Repository;

use App\Entity\News;
use App\Service\Pagination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NewsRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, News::class);
	}

	/**
	 * @return News[]
	 */
	public function findLatestNews(array $excludeIds = [], int $limit = 3): array
	{
		$qb = $this->createQueryBuilder('n');
		if ($excludeIds) {
			$qb->andWhere('n.id NOT IN (:excludeIds)')
				->setParameter('excludeIds', $excludeIds);
		}

		$qb
			->andWhere('n.active = TRUE')
			->orderBy('n.createdAt', 'DESC')
			->setMaxResults($limit);

		return $qb->getQuery()->getResult();
	}

	/**
	 * @param string $searchText
	 * @return \Generator<News>
	 */
	public function search(string $searchText): \Generator
	{
		$qb = $this->createQueryBuilder('News');

		$qb
			->select('News')
			->andWhere($qb->expr()->orX(
				$qb->expr()->andX('News.title LIKE :searchText'),
				$qb->expr()->andX('News.text LIKE :searchText'),
			))
			->andWhere('News.active = TRUE')
			->setParameter('searchText', '%' . $searchText . '%');

		yield from $qb->getQuery()->toIterable();
	}

	/**
	 * @param Pagination $pagination
	 * @return News[]
	 */
	public function buildPaginationArticles(Pagination $pagination): array
	{
		$qb = $this->createQueryBuilder('News');

		$qb
			->select('News')
			->andWhere('News.active = TRUE')
			->orderBy('News.createdAt', 'DESC')
			->setMaxResults($pagination->getPerPage())
			->setFirstResult($pagination->calculateOffset());

		return $qb->getQuery()->getResult();
	}

	public function findAllActiveCount(): int
	{
		$qb = $this->createQueryBuilder('News');

		$qb
			->select('COUNT(1)')
			->andWhere('News.active = TRUE');

		return $qb->getQuery()->getSingleScalarResult();
	}
}
