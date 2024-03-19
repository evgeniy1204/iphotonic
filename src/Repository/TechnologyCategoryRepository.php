<?php

namespace App\Repository;

use App\Entity\TechnologyCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechnologyCategory>
 *
 * @method TechnologyCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnologyCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnologyCategory[]    findAll()
 * @method TechnologyCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnologyCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnologyCategory::class);
    }

    //    /**
    //     * @return TechnologyCategory[] Returns an array of TechnologyCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TechnologyCategory
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
