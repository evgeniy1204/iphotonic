<?php

namespace App\Repository;

use App\Entity\Product;
use App\Service\SearchResultAwareInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements SearchEntityAwareInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

	/**
	 * @return \Generator<SearchResultAwareInterface>
	 */
	public function search(string $searchText): \Generator
	{
		$qb = $this->createQueryBuilder('Product');

		$qb
			->select('Product');

		//TODO: search like by title and text

		yield from $qb->getQuery()->toIterable();
	}
}
