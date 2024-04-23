<?php

namespace App\Repository;

use App\Entity\Possibilities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Possibilities>
 *
 * @method Possibilities|null find($id, $lockMode = null, $lockVersion = null)
 * @method Possibilities|null findOneBy(array $criteria, array $orderBy = null)
 * @method Possibilities[]    findAll()
 * @method Possibilities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PossibilitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Possibilities::class);
    }

	public function findPossibilitiesPage(): ?Possibilities
	{
		return $this->createQueryBuilder('Possibilities')
			->setMaxResults(1)
			->getQuery()
			->getOneOrNullResult()
			;
	}
}
