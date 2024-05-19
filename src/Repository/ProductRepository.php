<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\Technology;
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

	/**
	 * @param int[] $productCategoryIds
	 * @param int   $limit
	 *
	 * @return Product[]
	 */
    public function findByCategoryIds(array $productCategoryIds, int $limit = 4): array
    {
		$qb = $this->createQueryBuilder('Product');

		$qb
			->select('Product')
			->andWhere('Product.active = TRUE')
			->andWhere('Product.category IN (:productCategoryIds)')
			->setParameter('productCategoryIds', $productCategoryIds)
			->setMaxResults($limit);

		return $qb->getQuery()->getResult();
    }

	/**
	 * @return Product[]
	 */
	public function findProductsForMainPageWithCategory(ProductCategory $productCategory): array
	{
		$qb = $this->createQueryBuilder('Product');

		$qb
			->select('Product')
			->andWhere('Product.showOnMainPage = TRUE')
			->andWhere('Product.active = TRUE')
			->andWhere('Product.category = :productCategory')
			->setParameter('productCategory', $productCategory);

		return $qb->getQuery()->getResult();
	}

	/**
	 * @param Technology[] $technologies
	 * @return array
	 */
	public function findByTechnologies(array $technologies): array
	{
		$qb = $this->createQueryBuilder('Product');

		$qb
			->select('Product')
			->andWhere('Product.active = TRUE')
			->andWhere('Product.technology IN (:technologies)')
			->setParameter('technologies', $technologies);

		return $qb->getQuery()->getResult();
	}
}
