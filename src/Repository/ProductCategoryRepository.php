<?php

namespace App\Repository;

use App\Entity\ProductCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCategory::class);
    }

	/**
	 * @return ProductCategory[]
	 */
    public function findParentCategories(): array
    {
        return $this->createQueryBuilder('pc')
            ->andWhere('pc.parent IS NULL')
            ->getQuery()
            ->getResult();
    }
}
