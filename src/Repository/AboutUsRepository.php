<?php

namespace App\Repository;

use App\Entity\AboutUs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AboutUsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutUs::class);
    }

	public function findAboutUsPage(): ?AboutUs
	{
		return $this->createQueryBuilder('AboutUs')
				->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
	}
}
