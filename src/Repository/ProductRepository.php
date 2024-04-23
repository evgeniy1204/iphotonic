<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

	/**
	 * @return \Generator<Product>
	 */
	public function search(string $searchText): \Generator
	{
		$qb = $this->createQueryBuilder('Product');

		$qb
			->select('Product')
			->andWhere($qb->expr()->orX(
				$qb->expr()->andX('Product.name LIKE :searchText'),
				$qb->expr()->andX('Product.text LIKE :searchText'),
			))
			->andWhere('Product.active = TRUE')
			->setParameter('searchText', '%'.$searchText.'%');

		yield from $qb->getQuery()->toIterable();
	}

	/**
	 * @param Product $product
	 * @return Product[]
	 */
	public function findSimilarProducts(Product $product): array
	{
		$qb = $this->createQueryBuilder('Product');

		$qb
			->select('Product')
			->andWhere('Product.category = :category')
			->setParameter('category', $product->getCategory())
			->andWhere('Product.id != :currentProduct')
			->setParameter('currentProduct', $product);

		return $qb->getQuery()->getResult();
	}

    public function findByCategoryId(int $categoryId, int $limit = 4)
    {
        return $this->findBy(['category' => $categoryId, 'active' => true], limit: $limit);
    }
}
