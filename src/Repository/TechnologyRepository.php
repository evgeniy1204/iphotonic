<?php

namespace App\Repository;

use App\Entity\Technology;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Technology>
 *
 * @method Technology|null find($id, $lockMode = null, $lockVersion = null)
 * @method Technology|null findOneBy(array $criteria, array $orderBy = null)
 * @method Technology[]    findAll()
 * @method Technology[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnologyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Technology::class);
    }

	/**
	 * @param string $searchText
	 * @return \Generator<Technology>
	 */
	public function search(string $searchText): \Generator
	{
		$qb = $this->createQueryBuilder('Technology');

		$qb
			->select('Technology')
			->andWhere($qb->expr()->orX(
				$qb->expr()->andX('Technology.name LIKE :searchText'),
				$qb->expr()->andX('Technology.text LIKE :searchText'),
			))
			->andWhere('Technology.active = TRUE')
			->setParameter('searchText', '%'.$searchText.'%');

		yield from $qb->getQuery()->toIterable();
	}
}
