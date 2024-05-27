<?php

namespace App\Repository;

use App\Entity\Media;
use App\Service\Pagination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

	/**
	 * @param Pagination $pagination
	 * @return Media[]
	 */
	public function buildPaginationArticles(Pagination $pagination): array
	{
		$qb = $this->createQueryBuilder('Media');

		$qb
			->select('Media')
			->andWhere('Media.active = TRUE')
			->setMaxResults($pagination->getPerPage())
			->setFirstResult($pagination->calculateOffset());

		return $qb->getQuery()->getResult();
	}

	public function findAllActiveCount(): int
	{
		$qb = $this->createQueryBuilder('Media');

		$qb
			->select('COUNT(1)')
			->andWhere('Media.active = TRUE');

		return $qb->getQuery()->getSingleScalarResult();
	}

	public function findOneLastMedia(): ?Media
	{
		$qb = $this->createQueryBuilder('Media');

		$qb
			->select('Media')
			->andWhere('Media.active = TRUE')
			->setMaxResults(1);

		return $qb->getQuery()->getOneOrNullResult();
	}

	public function findNextMediaAfter(Media $media): ?Media
	{
		$qb = $this->createQueryBuilder('Media');

		$qb
			->select('Media')
			->andWhere('Media.active = TRUE')
			->andWhere('Media.id > :id')
			->setParameter('id', $media->getId())
			->setMaxResults(1);

		return $qb->getQuery()->getOneOrNullResult();
	}
}
