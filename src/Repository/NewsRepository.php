<?php

namespace App\Repository;

use App\Entity\News;
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
	public function findLatestNews(int $limit = 3): array
	{
		return $this->createQueryBuilder('n')
			->andWhere('n.active = true')
			->orderBy('n.createdAt', 'DESC')
			->setMaxResults($limit)
			->getQuery()
			->getResult();
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
}
