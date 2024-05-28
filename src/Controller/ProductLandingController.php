<?php

namespace App\Controller;

use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/catalog')]
class ProductLandingController extends AbstractController
{
    public function __construct(
        private readonly ProductCategoryRepository $productCategoryRepository
    ) {
    }

    #[Route('/', name: 'app_product_category_index', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        $productCategories = $this->productCategoryRepository->findParentCategories();

        return $this->render('product_category/index.html.twig', [
            'categories' => $productCategories,
        ]);
    }

	#[Route('/{productCategorySlug}/{productSubCategorySlug?}', name: 'app_product_category', methods: [Request::METHOD_GET])]
	public function productCategory(
		string $productCategorySlug,
		?string $productSubCategorySlug,
		ProductCategoryRepository $productCategoryRepository,
		ProductRepository $productRepository
	): Response {
		$productCategory = $productCategoryRepository->findOneBy(['slug' => $productSubCategorySlug ?? $productCategorySlug]);
		if ($productCategory) {
			$products = $productRepository->findByCategoryIds([$productCategory->getId()], 10);

			return $this->render('product_category/index.html.twig', [
				'productCategory' => $productCategory,
				'products' => $products,
			]);
		}
		return $this->getProductPage($productRepository, $productSubCategorySlug);

	}

	#[Route('/{productCategorySlug}/{productSubCategorySlug?}/{productSlug}', name: 'app_product_item', methods: [Request::METHOD_GET])]
	public function product(
		string $productCategorySlug,
		?string $productSubCategorySlug,
		string $productSlug,
		ProductRepository $productRepository
	): Response {
		return $this->getProductPage($productRepository, $productSlug);
	}

	private function getProductPage(ProductRepository $productRepository, string $slug): Response
	{
		$product = $productRepository->findOneBy(['slug' => $slug]);
		$similarProducts = $productRepository->findSimilarProducts($product);

		$relationBlockTitle = 'Thing coating';
		$relationProductCategories = [];
		foreach ($product->getRelationProducts() as $relationProduct) {
			$relationProductCategories[] = $relationProduct->getCategory()->getName();
		}
		$relationProductCategories = array_unique($relationProductCategories);
		$relationBlockTitle = count($relationProductCategories) === 1 ? $relationProductCategories[0] : $relationBlockTitle;

		return $this->render('product/item.html.twig', [
			'product' => $product,
			'similarProducts' => $similarProducts,
			'relationBlockTitle' => $relationBlockTitle
		]);
	}
}
