<?php

namespace App\Controller;

use App\Dto\Query\ProductCategoryQueryParams;
use App\Repository\ProductCategoryRepository;
use App\Response\ProductCategoryResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class ProductCategoryController extends AbstractController
{
    public function __construct(
        private readonly ProductCategoryRepository $productCategoryRepository
    )
    {
    }

    #[Route('/product/category', name: 'app_product_category')]
    public function index(
        #[MapQueryString] ?ProductCategoryQueryParams $queryParams
    ): Response
    {
        $productCategories = $this->productCategoryRepository->findParentCategories();
        $chosenCategory = null !== $queryParams ?
            $this->productCategoryRepository->find($queryParams->getChosenCategory())
            : null;

        $response = new ProductCategoryResponse(
            $productCategories,
            $chosenCategory
        );

        dd($response);

        return $this->render('product_category/index.html.twig', [
            'controller_name' => 'ProductCategoryController',
        ]);
    }
}
