<?php

namespace App\Controller;

use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/catalog')]
class ProductLandingController extends AbstractController
{
    public function __construct(
        private readonly ProductCategoryRepository $productCategoryRepository
    )
    {
    }

    #[Route('/', name: 'app_product_category_index')]
    public function index(): Response
    {
        $productCategories = $this->productCategoryRepository->findParentCategories();

        return $this->render('product_category/index.html.twig', [
            'categories' => $productCategories,
        ]);
    }

	#[Route('/{productCategorySlug}/{productSubCategorySlug?}', name: 'app_product_category')]
	public function productCategory(
		string $productCategorySlug,
		?string $productSubCategorySlug,
		ProductCategoryRepository $productCategoryRepository
	): Response {
		$productCategory = $productCategoryRepository->findOneBy(['slug' => $productSubCategorySlug ?? $productCategorySlug]);

		return $this->render('product_category/index.html.twig', [
			'productCategory' => $productCategory,
		]);
	}

	#[Route('/{productCategorySlug}/{productSubCategorySlug}/{productSlug}', name: 'app_product_item')]
	public function product(
		string $productCategorySlug,
		string $productSubCategorySlug,
		string $productSlug,
		ProductRepository $productRepository
	): Response {
		$product = $productRepository->findOneBy(['slug' => $productSlug]);
		$similarProducts = $productRepository->findSimilarProducts($product);

		$relationBlockTitle = 'Thing coating';
		$relationProductCategories = [];
		foreach ($product->getRelationProducts() as $relationProduct) {
			$relationProductCategories[] = $relationProduct->getCategory()->getName();
		}
		$relationProductCategories = array_unique($relationProductCategories);
		$relationBlockTitle = count($relationProductCategories) === 1 ? $relationProductCategories[0] : $relationBlockTitle;

		return $this->render('product/index.html.twig', [
			'product' => $product,
			'similarProducts' => $similarProducts,
			'relationBlockTitle' => $relationBlockTitle
		]);
	}
}
