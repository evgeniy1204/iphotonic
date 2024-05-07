<?php

namespace App\Repository;

use App\Entity\Possibilities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
			->getOneOrNullResult();
	}
}
