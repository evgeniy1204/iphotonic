<?php

namespace App\Controller;

use App\Dto\CardInfoDto;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Service\UrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
		ProductRepository $productRepository,
		UrlGenerator $urlGenerator,
	): Response {
		/** @var ProductCategory $productCategory */
		$productCategory = $productCategoryRepository->findOneBy(['slug' => $productSubCategorySlug ?? $productCategorySlug]);
		if ($productCategory) {
			$cards = [];
			$products = $productRepository->findByCategoryIds([$productCategory->getId()], 100);
			foreach ($productCategory->getChildren() as $productCategoryChild) {
				$cards[] = new CardInfoDto(
					$productCategoryChild->getPreviewImagePath(),
					$urlGenerator->generateProductCategoryUrl($productCategoryChild),
					$productCategoryChild->getName(),
					$productCategoryChild->getSummary(),
					$productCategoryChild->getMenuOrder(),
				);
			}
			foreach ($products as $product) {
				$cards[] = new CardInfoDto(
					$product->getPreviewImagePath(),
					$urlGenerator->generateProductUrl($product),
					$product->getName(),
					$product->getSummary(),
					$product->getMenuOrder(),
				);
			}
			$sortFunc = function (CardInfoDto $aDto, CardInfoDto $bDto) {
				return $aDto->getOrderNumber() > $bDto->getOrderNumber();
			};
			usort($cards, $sortFunc);

			return $this->render('product_category/index.html.twig', [
				'productCategory' => $productCategory,
				'cards' => $cards,
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
		/** @var $product Product */
		$product = $productRepository->findOneBy(['slug' => $slug]);
		if (!$product) {
			throw new NotFoundHttpException();
		}

		$relationBlockTitle = '';
		$relationProductCategories = [];
		foreach ($product->getRelationProducts() as $relationProduct) {
			$relationProductCategories[] = $relationProduct->getCategory()->getName();
		}
		$relationProductCategories = array_unique($relationProductCategories);
		$relationBlockTitle = count($relationProductCategories) === 1 ? $relationProductCategories[0] : $relationBlockTitle;

		$relationSecondBlockTitle = '';
		$relationSecondProductCategories = [];
		foreach ($product->getRelationSecondProducts() as $relationSecondProduct) {
			$relationSecondProductCategories[] = $relationSecondProduct->getCategory()->getName();
		}
		$relationSecondProductCategories = array_unique($relationSecondProductCategories);
		$relationSecondBlockTitle = count($relationSecondProductCategories) === 1 ? $relationSecondProductCategories[0] : $relationSecondBlockTitle;
		if (!$relationSecondBlockTitle) {
			if ($firstProduct = $product->getRelationSecondProducts()->first()) {
				$relationSecondBlockTitle = $firstProduct->getCategory()?->getName();
			}
		}

		return $this->render('product/item.html.twig', [
			'product' => $product,
			'similarProducts' => $productRepository->findSimilarProducts($product),
			'relationBlockTitle' => $relationBlockTitle,
			'relationSecondBlockTitle' => $relationSecondBlockTitle
		]);
	}
}
