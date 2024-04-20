<?php

namespace App\Repository;

use App\Entity\ProductCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductCategory>
 *
 * @method ProductCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductCategory[]    findAll()
 * @method ProductCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCategory::class);
    }

    public function findParentCategories()
    {
        return $this->createQueryBuilder('pc')
            ->andWhere('pc.parent IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function findByParentId(int $parentId)
    {
        return $this->createQueryBuilder('pc')
            ->andWhere('pc.parent = :parent_id')
            ->setParameter('parent_id', $parentId)
            ->getQuery()
            ->getResult();
    }
}
